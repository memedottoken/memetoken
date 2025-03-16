import React, { useEffect, useState, useMemo } from "react";

import { clusterApiUrl, Connection, PublicKey, Transaction, SystemProgram } from "@solana/web3.js";
import {
  useWallet
} from "@solana/wallet-adapter-react";
import {
  WalletMultiButton,
} from "@solana/wallet-adapter-react-ui";

import { TOKEN_PROGRAM_ID, getAssociatedTokenAddress, createTransferInstruction } from "@solana/spl-token";
// import { notify } from "@/utils/notifications";

const PUMP_FUN_API = "https://pump.fun/api";
const SOLANA_RPC = clusterApiUrl() || "https://api.mainnet-beta.solana.com";
const connection = new Connection(SOLANA_RPC);

const Token = () => {
  const wallet = useWallet();

  const [tokens, setTokens] = useState([
    { mint:"DxGLUu4pFBDmR7bndVjf9Y261tj91eQD4FqGvC8N6pSS", price: 0.00001, name: "MULTIPOSE", symbol: "MLP", owner:"C1HUPMoMZ2BMaVLw7tdXqDuXSSRfkzowRGHv2xecVQaV" },
    { price:0.0034, "name": "Catamin Eyes", "symbol": "CATAMINEYE", "uri": "https://ipfs.io/ipfs/Qmbzh7KfxGdxsEL8BfbKoiQN99v3A5aVeA2dv4Hb5gctvn", "mint": "7kxmxAfD1yUx9yYyjo643NjAxwiRW4URdzLCrw7xpump", "bondingCurve": "CNybDgSPefNdhcmaMhwjwBGE2F4XqEKigA2tsN9FxDM3", "owner": "B7Cevu3GtM7YguAtUE1mxAoFPAiJ8r4ESNyd2ZXd5Pim"}
  ]);
  const [selectedToken, setSelectedToken] = useState(null);
  const [amount, setAmount] = useState(0);

  useEffect(() => {
    // fetchTokens();
  }, []);

  const fetchTokens = async () => {
    try {
      const response = await fetch(`${PUMP_FUN_API}/tokens`);
      const data = await response.json();
      setTokens(data);
    } catch (error) {
      console.error("Error fetching tokens:", error);
    }
  };

  const getTokenAccount = async (mint) => {
    if (!wallet.publicKey) return null;
    return await getAssociatedTokenAddress(new PublicKey(mint), wallet.publicKey);
  };

  const handleBuy = async () => {
    if (!wallet.connected || !selectedToken || amount <= 0) return;
    try {
      const transaction = new Transaction().add(
        SystemProgram.transfer({
          fromPubkey: wallet.publicKey,
          toPubkey: new PublicKey(selectedToken.owner),
          lamports: 2000 || amount * selectedToken.price, // Convert to lamports
        })
      );
      const { blockhash } = await connection.getLatestBlockhash();
      transaction.recentBlockhash = blockhash;
      transaction.feePayer = wallet.publicKey;

      const signedTransaction = await wallet.signTransaction(transaction);
      const txid = await connection.sendRawTransaction(signedTransaction.serialize());
      // notify("success", `Transaction Sent: ${txid}`);
    } catch (error) {
      console.error("Buy failed:", error);
      // notify("error", "Buy transaction failed");
    }
  };

  const handleSell = async () => {
    if (!wallet.connected || !selectedToken || amount <= 0) return;
    try {
      const tokenAccount = await getTokenAccount(selectedToken.mint);
      const transaction = new Transaction().add(
        createTransferInstruction(
          tokenAccount,
          new PublicKey(selectedToken.owner),
          wallet.publicKey,
          amount,
          [],
          TOKEN_PROGRAM_ID
        )
      );
      const { blockhash } = await connection.getLatestBlockhash();
      transaction.recentBlockhash = blockhash;
      transaction.feePayer = wallet.publicKey;

      const signedTransaction = await wallet.signTransaction(transaction);
      const txid = await connection.sendRawTransaction(signedTransaction.serialize());
      // notify("success", `Sold ${amount} ${selectedToken.symbol}. TX: ${txid}`);
    } catch (error) {
      console.error("Sell failed:", error);
      // notify("error", "Sell transaction failed");
    }
  };

  return (
    <div className="p-4 bg-gray-900 text-white rounded-lg">
      <h1 className="text-xl font-bold mb-4">Pump.fun Memecoin Trader</h1>
      <WalletMultiButton />
      {wallet.connected && (
        <>
          <select className="p-2 mt-4" onChange={(e) => setSelectedToken(tokens.find(t => t.mint === e.target.value))}>
            <option value="">Select a token</option>
            {tokens.map((token) => (
              <option key={token.mint} value={token.mint}>{token.symbol} - {token.price} SOL</option>
            ))}
          </select>
          <input
            type="number"
            className="p-2 mt-2"
            placeholder="Amount"
            value={amount}
            onChange={(e) => setAmount(e.target.value)}
          />
          <div className="flex gap-2 mt-4">
            <button className="bg-green-500 p-2 rounded" onClick={handleBuy}>Buy</button>
            <button className="bg-red-500 p-2 rounded" onClick={handleSell}>Sell</button>
          </div>
        </>
      )}
    </div>
  );
};

export default Token;

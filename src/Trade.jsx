import { useState } from 'react';
import { useConnection, useWallet } from '@solana/wallet-adapter-react';
import { PublicKey, clusterApiUrl } from '@solana/web3.js';
import * as raydium from '@raydium-io/raydium-sdk';


const Trade = () => {
  const [amount, setAmount] = useState('');
  const [memecoin, setMemecoin] = useState('');
  const { connection } = useConnection();
  let { wallet } = useWallet();
  const handleTrade = async () => {
    wallet = window.wallet
    console.log('::HANDLING::', wallet)
    if (!wallet.publicKey) return;
    const trade = await raydium.swap({
      connection,
      wallet: wallet.publicKey,
      amount: amount,
      tokenIn: new PublicKey(memecoin),
      tokenOut: new PublicKey('So11111111111111111111111111111111111111112'), // Example: swapping for SOL
      slippage: 0.05,
      priorityFee: 0.01,
      payer: wallet.publicKey,
      version: 'v0',
    });
    const signature = await wallet.sendTransaction(trade.transaction, connection);
    console.log(`Transaction ${signature} sent!`);
  };

  return (
    <div>
      <input
        type="text"
        placeholder="Enter memecoin amount"
        value={amount}
        onChange={(e) => setAmount(e.target.value)}
      />
      <input
        type="text"
        placeholder="Enter memecoin address"
        value={memecoin}
        onChange={(e) => setMemecoin(e.target.value)}
      />
      <button onClick={handleTrade}>Trade</button>
    </div>
  );
};

export default Trade;
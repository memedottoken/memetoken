import { Connection, Keypair, Transaction, VersionedTransaction, sendAndConfirmTransaction } from "@solana/web3.js";
import axios from "axios";
import bs58 from "bs58";

async function performSwap() {
  const connection = new Connection("https://api.mainnet-beta.solana.com");
  const keypair = Keypair.fromSecretKey(bs58.decode("YOUR_PRIVATE_KEY"));

  const params = new URLSearchParams({
    from: "So11111111111111111111111111111111111111112", // SOL
    to: "EPjFWdd5AufqSSqeM2qN1xzybapC8G4wEGGkZwyTDt1v", // USDC
    amount: 0.5, // From amount
    slip: 10, // Slippage
    payer: keypair.publicKey.toBase58(),
    fee: 0.00009, // Priority fee
    txType: "v0", // Change to "legacy" for legacy transactions
  });

  try {
    const response = await axios.get(`https://swap.solxtence.com/swap?${params}`);
    const { serializedTx, txType } = response.data.transaction;

    const { blockhash } = await connection.getLatestBlockhash();
    let transaction;
    if (txType === "v0") {
      transaction = VersionedTransaction.deserialize(Buffer.from(serializedTx, "base64"));
      transaction.message.recentBlockhash = blockhash;
      transaction.sign([keypair]);
    } else {
      transaction = Transaction.from(Buffer.from(serializedTx, "base64"));
      transaction.recentBlockhash = blockhash;
      transaction.sign(keypair);
    }

    const signature = await sendAndConfirmTransaction(connection, transaction);
    console.log("Swap successful! Transaction signature:", signature);
  } catch (error) {
    console.error("Error performing swap:", error);
  }
}

performSwap();
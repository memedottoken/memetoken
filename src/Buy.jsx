import { useEffect, useState } from "react";
import { Connection, PublicKey, Transaction, SystemProgram } from "@solana/web3.js";
import { useWallet, WalletProvider, ConnectionProvider } from "@solana/wallet-adapter-react";
import { WalletModalProvider, WalletMultiButton } from "@solana/wallet-adapter-react-ui";

const RPC_URL = "https://api.mainnet-beta.solana.com";
const connection = new Connection(RPC_URL);
const MEMECOIN_MINT = "YourMemecoinMintAddress"; // Replace with actual token mint address
const MEMECOIN_DECIMALS = 6; // Adjust based on your memecoin

const TradeMemecoins = () => {
    const { publicKey, sendTransaction } = useWallet();
    const [balance, setBalance] = useState(0);

    useEffect(() => {
        const fetchBalance = async () => {
            if (publicKey) {
                let balance = await connection.getBalance(publicKey);
                setBalance(balance / 1e9); // Convert lamports to SOL
            }
        };
        fetchBalance();
    }, [publicKey]);

    const handleBuy = async () => {
        if (!publicKey) return alert("Connect your wallet first");

        const transaction = new Transaction().add(
            SystemProgram.transfer({
                fromPubkey: publicKey,
                toPubkey: new PublicKey("FR5rrbg1skncrJLyTwevjsrJWq5gAyLwRFmSsvPKpump"), // Replace with exchange address
                lamports: 0.01 * 1e9, // Example: buying 0.01 SOL worth of memecoins
            })
        );

        try {
            const signature = await sendTransaction(transaction, connection);
            alert(`Transaction sent: ${signature}`);
        } catch (error) {
            console.error("Transaction failed", error);
        }
    };

    const handleSell = async () => {
        alert("Selling functionality will depend on token program integration");
    };

    return (
        <div className="p-4 bg-gray-900 text-white rounded-xl shadow-lg max-w-md mx-auto">
            <h2 className="text-xl font-bold">Solana Memecoin Trading</h2>
            <WalletMultiButton className="mt-4" />
            
            {publicKey && <p className="mt-2">Balance: {balance.toFixed(4)} SOL</p>}
            <div className="flex space-x-4 mt-4">
                <button className="bg-green-500 px-4 py-2 rounded" onClick={handleBuy}>Buy Memecoin</button>
                <button className="bg-red-500 px-4 py-2 rounded" onClick={handleSell}>Sell Memecoin</button>
            </div>
        </div>
    );
};

const App = () => {
    return (
        <ConnectionProvider endpoint={RPC_URL}>
            <WalletProvider wallets={[]} autoConnect>
                <WalletModalProvider>
                    <TradeMemecoins />
                </WalletModalProvider>
            </WalletProvider>
        </ConnectionProvider>
    );
};

export default App;

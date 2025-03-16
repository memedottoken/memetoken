import { useWallet } from "@solana/wallet-adapter-react";
import { WalletModalProvider } from "@solana/wallet-adapter-react-ui";
import {
  WalletMultiButton,
} from "@solana/wallet-adapter-react-ui";

const WalletConnect = (props) => {
 const { publicKey } = window.wallet = useWallet()
  return (
    <WalletModalProvider>
      <div className="text-base font-bookweb relative rounded-3xl duration-500 ease-out text-green-900">
        <div className="mt-0.5 -ml-px absolute h-1/2 w-1/5 rounded-tl-full border-t-2 border-l border-current top-0 left-0" />
        <div className="mt-2 rounded-3xl overflow-hidden absolute inset-0 text-green-800 m-1 mb-2">
          <div
            style={{ transformOrigin: "top right", animationDuration: "3s" }}
            className="w-1/3 top-1/2 origin-center bg-gradient-to-r from-transparent via-current to-tansparent absolute animate-spin p-10"
          />
        </div>
        <div className="absolute h-1/2 w-1/4 rounded-br-full bottom-0 right-0 border-b-2 border-r border-current mb-0.5 -mr-0.5" />
        <div className="mt-2 m-1 relative inline-block rounded-inherit font-semibold backdrop-filter backdrop-blur-lg text-green-600">
          <WalletMultiButton style={{ background:'transparent', color:'currentColor' }}/>
        </div>
      </div>
    </WalletModalProvider>
  );
};

export default WalletConnect;
import WalletContextProvider from "./WalletContextProvider";
import ConnectButton from './WalletConnect';

const Connect = ()=>{

  return (
    <WalletContextProvider>
        <ConnectButton/>
    </WalletContextProvider>
  )
}

export default Connect;
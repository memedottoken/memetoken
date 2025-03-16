import WalletContextProvider from "./WalletContextProvider";
import Token from "./Token";

const TokenCtx = ()=>{

    return (
      <WalletContextProvider>
          <Token/>
      </WalletContextProvider>
    )
  }
  
  export default TokenCtx;
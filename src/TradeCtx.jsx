import WalletContextProvider from "./WalletContextProvider";
import Trade from "./Trade";

const TradeCtx = ()=>{

    return (
      <WalletContextProvider>
          <Trade/>
      </WalletContextProvider>
    )
  }
  
  export default TradeCtx;
import { StrictMode } from 'react'
import { createRoot } from 'react-dom/client'
import './index.css'
import Connect from './Connect.jsx'
import TradeCtx from './TradeCtx.jsx'


createRoot(document.getElementById('connect')).render(
  <StrictMode>
    <Connect/>
  </StrictMode>,
)

createRoot(document.getElementById('root')).render(
  <StrictMode>
    <TradeCtx/>
  </StrictMode>,
)

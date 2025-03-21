import vitePluginSocketIO from 'vite-plugin-socket-io'
import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react-swc';
import stream from './stream';

// https://vite.dev/config/
export default defineConfig({
  plugins: [
    vitePluginSocketIO({ socketEvents: (io, socket)=>stream(socket) }),
    react(),
  ],
  define: {
    'process.env': {}
  }
})

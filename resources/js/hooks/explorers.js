import { computed } from 'vue';

import { get } from '@vueuse/core';
import { useChainId } from '@wagmi/vue';
import { getAddress } from 'viem';
import { arbitrum, arbitrumNova, avalanche, avalancheFuji, base, blast, bsc, bscTestnet, celo, mainnet, optimism, sepolia, worldchain, zora } from 'viem/chains';
const explorers = {
    etherscan: (link, data, type) => {
        switch (type) {
            case 'transaction':
                return `${link}/tx/${data}`;
            default:
                return `${link}/${type}/${data}`;
        }
    },

    blockscout: (link, data, type) => {
        switch (type) {
            case 'transaction':
                return `${link}/tx/${data}`;
            case 'token':
                return `${link}/tokens/${data}`;
            default:
                return `${link}/${type}/${data}`;
        }
    },

    harmony: (link, data, type) => {
        switch (type) {
            case 'transaction':
                return `${link}/tx/${data}`;
            case 'token':
                return `${link}/address/${data}`;
            default:
                return `${link}/${type}/${data}`;
        }
    },

    okex: (link, data, type) => {
        switch (type) {
            case 'transaction':
                return `${link}/tx/${data}`;
            case 'token':
                return `${link}/tokenAddr/${data}`;
            default:
                return `${link}/${type}/${data}`;
        }
    },
    moonriver: (link, data, type) => {
        switch (type) {
            case 'transaction':
                return `${link}/tx/${data}`;
            case 'token':
                return `${link}/tokens/${data}`;
            default:
                return `${link}/${type}/${data}`;
        }
    },
    fuse: (link, data, type) => {
        switch (type) {
            case 'transaction':
                return `${link}/tx/${data}`;
            case 'token':
                return `${link}/tokens/${data}`;
            default:
                return `${link}/${type}/${data}`;
        }
    },
    telos: (link, data, type) => {
        switch (type) {
            case 'transaction':
                return `${link}/transaction/${data}`;
            case 'token':
                return `${link}/address/${data}`;
            case 'address':
                return `${link}/address/${data}`;
            default:
                return `${link}/${type}/${data}`;
        }
    },
    moonbeam: (link, data, type) => {
        switch (type) {
            case 'transaction':
                return `${link}/tx/${data}`;
            case 'token':
                return `${link}/tokens/${data}`;
            default:
                return `${link}/${type}/${data}`;
        }
    },
};

const chains = {
    [mainnet.id]: {
        link: 'https://etherscan.io',
        builder: explorers.etherscan,
    },
    [sepolia.id]: {
        link: 'https://sepolia.etherscan.io',
        builder: explorers.etherscan,
    },
    [bsc.id]: {
        link: 'https://bscscan.com',
        builder: explorers.etherscan,
    },
    [bscTestnet.id]: {
        link: 'https://testnet.bscscan.com',
        builder: explorers.etherscan,
    },
    [arbitrum.id]: {
        link: 'https://arbiscan.io',
        builder: explorers.etherscan,
    },

    [avalanche.id]: {
        link: 'https://cchain.explorer.avax.network',
        builder: explorers.blockscout,
    },
    [avalancheFuji.id]: {
        link: 'https://cchain.explorer.avax-test.network',
        builder: explorers.etherscan,
    },
    [optimism.id]: {
        link: 'https://optimistic.etherscan.io',
        builder: explorers.etherscan,
    },
    [arbitrumNova.id]: {
        link: 'https://nova-explorer.arbitrum.io',
        builder: explorers.blockscout,
    },
    [base.id]: {
        link: 'https://basescan.org/',
        builder: explorers.etherscan,
    },
    [celo.id]: {
        link: 'https://celoscan.io/',
        builder: explorers.etherscan,
    },
    [blast.id]: {
        link: 'https://blastscan.io/',
        builder: explorers.etherscan,
    },
    [zora.id]: {
        link: 'https://explorer.zora.energy/',
        builder: explorers.etherscan,
    },
    [worldchain.id]: {
        link: 'https://worldscan.org/',
        builder: explorers.etherscan,
    }
};

export function getExplorerLink(
    chainId,
    data,
    type
) {
    if (!chainId) return '';
    const chain = chains[chainId];
    return chain.builder(chain.link, data, type);
}


export function shortenAddress(address, chars = 4) {
    if (!address) return null;
    if (address?.length <= chars) return address;
    return `${address.substring(0, parseInt(chars) + 2)}...${address.substring(
        42 - chars,
    )}`;
}
// shorten the checksummed version of the input address to have 0x + 4 characters at start and end

export function truncateTx(fullStr = "", strLen = 33, separator = "...") {
    if (fullStr?.length <= strLen) return fullStr;
    const sepLen = separator.length;
    const charsToShow = strLen - sepLen;
    const frontChars = Math.ceil(charsToShow / 2);
    const backChars = Math.floor(charsToShow / 2);
    return (
        fullStr.substring(0, frontChars + 3) +
        separator +
        fullStr.substring(fullStr.length - backChars - 3)
    );
}


export function useTxHash(txhash, chId = null, chars = 18) {
    const chainId = useChainId();
    const shortTx = computed(() => {
        if (!get(txhash) || get(txhash).length < 30) return "";
        return truncateTx(get(txhash), chars);
    });
    const etherScanLink = computed(() => {
        if (!get(txhash) || get(txhash).length < 30) return "";
        return getExplorerLink(chId ?? chainId.value, get(txhash), 'transaction');
    });
    return [shortTx, etherScanLink];
}

export function useAddress(txAddress, chId = null, chars = 4) {
    const chainId = useChainId();
    const shortTx = computed(() => {
        const address = isAddress(get(txAddress));
        if (!address) return "";
        return shortenAddress(address, chars);
    });
    const etherScanLink = computed(() => {
        const address = isAddress(get(txAddress));
        if (!address) return "";
        return getExplorerLink(chId ?? chainId.value, get(txAddress), 'address');
    });
    return [shortTx, etherScanLink];
}

export function isAddress(value) {
    try {
        return getAddress(value);
    } catch {
        return null;
    }
}

import { formatEther, formatUnits, parseEther, parseUnits } from 'viem';

export const tokenAmount = (
    ethReserve,    // ETH reserve in wei (bigint)
    tokenReserve,  // Token reserve in smallest unit (bigint)
    ethAmount,     // Amount of ETH as decimal string (e.g., "1.5")
    slippage,      // Slippage tolerance in percentage (e.g., 0.5 for 0.5%)
    tokenDecimals = 18  // Token decimals, defaults to 18
) => {

    try {
        // Convert ETH amount to Wei (returns bigint)
        const amountInWei = parseEther(ethAmount);

        // Input validation
        if (ethReserve <= 0n || tokenReserve <= 0n || amountInWei <= 0n || slippage < 0) {
            return {
                expectedOutputAmount: 0,      // ETH formatted string
                minimumOutputAmount: 0,        // ETH formatted string
                expectedOutputAmountWei: 0,    // Wei as string
                minimumOutputAmountWei: 0,     // Wei as string
                priceImpact: "0%"
            };
        }

        // Calculate constant product (k)
        const k = ethReserve * tokenReserve;

        // Calculate new ETH reserve after swap
        const newEthReserve = ethReserve + amountInWei;

        // Calculate new token reserve using constant product formula
        // k = (ethReserve + amountInWei) * (tokenReserve - outputAmount)
        const newTokenReserve = k / newEthReserve;

        // Calculate expected token output amount
        const expectedOutputAmount = tokenReserve - newTokenReserve;

        // Calculate minimum acceptable amount with slippage
        const slippageMultiplier = 100n - BigInt(slippage);
        const minimumOutputAmount = (expectedOutputAmount * slippageMultiplier) / 100n;

        // Calculate price impact
        const priceImpact = (Number(amountInWei * 10000n / ethReserve)) / 100;

        return {
            expectedOutputAmount: parseFloat(formatUnits(expectedOutputAmount, tokenDecimals)).toFixed(),
            minimumOutputAmount: formatUnits(minimumOutputAmount, tokenDecimals),
            expectedOutputAmountWei: expectedOutputAmount.toString(),
            minimumOutputAmountWei: minimumOutputAmount.toString(),
            priceImpact: priceImpact.toFixed(2) + "%"
        };
    } catch (error) {
        throw new Error(`Calculation error: ${error.message}`);
    }
};


export const ethAmount = (
    ethReserve,    // ETH reserve in wei (bigint)
    tokenReserve,  // Token reserve in smallest unit (bigint)
    tokenAmount,   // Amount of tokens as decimal string (e.g., "100.5")
    slippage,      // Slippage tolerance in percentage (e.g., 0.5 for 0.5%)
    tokenDecimals = 18 // Token decimals, defaults to 18
) => {

    try {
        // Convert token amount to smallest unit (returns bigint)
        const amountInSmallestUnit = parseUnits(tokenAmount, tokenDecimals);
        // Input validation
        if (ethReserve <= 0n || tokenReserve <= 0n || amountInSmallestUnit <= 0n || slippage < 0) {
            return {
                expectedOutputAmount: 0,      // ETH formatted string
                minimumOutputAmount: 0,        // ETH formatted string
                expectedOutputAmountWei: 0,    // Wei as string
                minimumOutputAmountWei: 0,     // Wei as string
                priceImpact: "0%"
            };
            // throw new Error("Invalid input parameters");
        }

        // Calculate constant product (k)
        const k = ethReserve * tokenReserve;

        // Calculate new token reserve after swap
        const newTokenReserve = tokenReserve + amountInSmallestUnit;

        // Calculate new ETH reserve using constant product formula
        // k = (ethReserve - outputAmount) * (tokenReserve + amountInSmallestUnit)
        const newEthReserve = k / newTokenReserve;

        // Calculate expected ETH output amount
        const expectedOutputAmount = ethReserve - newEthReserve;

        // Calculate minimum acceptable amount with slippage
        const slippageMultiplier = 100n - BigInt(slippage);
        const minimumOutputAmount = (expectedOutputAmount * slippageMultiplier) / 100n;

        // Calculate price impact
        const priceImpact = (Number(amountInSmallestUnit * 10000n / tokenReserve)) / 100;

        return {
            expectedOutputAmount: formatEther(expectedOutputAmount),      // ETH formatted string
            minimumOutputAmount: formatEther(minimumOutputAmount),       // ETH formatted string
            expectedOutputAmountWei: expectedOutputAmount.toString(),    // Wei as string
            minimumOutputAmountWei: minimumOutputAmount.toString(),     // Wei as string
            priceImpact: priceImpact.toFixed(2) + "%"
        };
    } catch (error) {
        throw new Error(`Calculation error: ${error.message}`);
    }
};

export const calculateSlippage = (amount, slippage) => {
    // Calculate minimum acceptable amount with slippage
    const slippageMultiplier = 100n - BigInt(Math.floor(slippage * 100));
    return (amount * slippageMultiplier) / 100n;
};

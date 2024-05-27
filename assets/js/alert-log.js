(function() {
    if (!('fetch' in window)) {
        console.error('Fetch API not supported, cannot log error.');
        return;
    }

    console.log("Digiflow.be error logging initialized");

    const logError = async (errorData) => {
        try {
            console.log('Sending error data:', errorData);
            const response = await fetch('https://digiflowroot.be/logs/handler.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(errorData)
            });

            if (!response.ok) {
                originalConsoleError('Failed to log error, server responded with status:', response.status);
                const text = await response.text();
                originalConsoleError('Response text:', text);
            } else {
                originalConsoleLog('Error logged successfully:', errorData);
            }
        } catch (err) {
            originalConsoleError('Failed to log JavaScript error:', err);
        }
    };

    const handleErrorEvent = (message, source, lineno, colno, error) => {
        const errorData = {
            website: window.location.hostname,
            page: window.location.pathname,
            time: new Date().toISOString(),
            message,
            source: source || extractSourceFromStack(error) || 'unknown',
            lineno,
            colno,
            error: error ? error.stack : null
        };

        originalConsoleError('Error captured:', errorData);
        logError(errorData);
    };

    const extractSourceFromStack = (error) => {
        if (error && error.stack) {
            const stackLines = error.stack.split('\n');
            if (stackLines.length > 1) {
                const match = stackLines[1].match(/(?:\()?(.*):(\d+):(\d+)\)?$/);
                if (match) {
                    return match[1];
                }
            }
        }
        return null;
    };

    // Save the original console methods
    const originalConsoleError = console.error;
    const originalConsoleLog = console.log;

    console.error = function(...args) {
        if (args.some(arg => arg && arg.toString().includes('logError'))) {
            // Avoid logging errors from the logError function
            originalConsoleError.apply(console, args);
        } else {
            handleErrorEvent(args.join(' '), '', '', '', new Error());
            originalConsoleError.apply(console, args);
        }
    };

    window.addEventListener('error', event => {
        const { message, filename, lineno, colno, error } = event;
        handleErrorEvent(message, filename || 'unknown', lineno, colno, error);
    });

    window.addEventListener('unhandledrejection', event => {
        const reason = event.reason || {};
        handleErrorEvent(reason.message || 'Unhandled promise rejection', reason.stack ? extractSourceFromStack(reason) : 'unknown', '', '', reason.stack || null);
    });

})();

export default function decodeJwtPayload(token) {
    try {
        // Check if token exists and is a string
        if (!token || typeof token !== 'string') {
            throw new Error('Invalid token: Token must be a non-empty string');
        }

        // Check if token has the correct format (three parts separated by dots)
        const parts = token.split('.');
        if (parts.length !== 3) {
            throw new Error('Invalid token format: Token must have three parts');
        }

        const base64Url = parts[1];
        const base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
        const jsonPayload = decodeURIComponent(
            atob(base64)
                .split('')
                .map((c) => '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2))
                .join('')
        );

        const decoded = JSON.parse(jsonPayload);
        if (!decoded) {
            throw new Error('Invalid token payload: Could not parse JSON');
        }

        return decoded;
    } catch (error) {
        console.error('Error decoding JWT:', error.message);
        return null;
    }
}

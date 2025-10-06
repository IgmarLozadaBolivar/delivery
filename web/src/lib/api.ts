const uri = "http://localhost:8000";
const headers = {
    "Content-Type": "application/json",
    Accept: "application/json"
}

export async function auth(email: string, password: string) {
    try {
        const res = await fetch(`${uri}/api/users/login`, {
            method: "POST",
            headers: headers,
            body: JSON.stringify({ email, password })
        });

        if (!res.ok) {
            let errMsg = "Error desconocido en login";
            try {
                const data = await res.json();
                errMsg = data.message || errMsg;
            } catch {
                errMsg = await res.text();
            }
            throw new Error(errMsg);
        }

        return await res.json();
    } catch (error: any) {
        throw new Error(`${error.message}`);
    }
}
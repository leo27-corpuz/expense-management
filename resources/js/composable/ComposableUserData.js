import axios from 'axios';
const userData = async (token, user) => {
    const config = {
        'Content-Type': 'application/json',
        headers: { Authorization: `Bearer ${token}` }
    };
    try {
       const response = await axios.get('http://127.0.0.1:8000/api/isLogin', config)
        await response.data
    } catch (error) {
        localStorage.removeItem("token")
        localStorage.removeItem("user")
    }
}
export default userData
import axios from 'axios';

export default async function searchZipCodeInformation(zip_code) {
    try {
        const res = await axios.get(`https://viacep.com.br/ws/${zip_code}/json/`);

        return res;
    } catch (err) {
        console.error(err.data);

        return false;
    }
}

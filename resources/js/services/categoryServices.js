import axios from 'axios';
import {config, getAuthToken, formattedDate} from './../config';

const categoryServices =  {
    getAll: async function (page, limit, keywords) {

        const authToken = getAuthToken();
        const response = await axios.get(`${config.baseUrl}/api/admin/category`, {
            params: {
                page: page,
                limit: limit,
                keywords: keywords,
            },
            headers: {
                Authorization: `Bearer ${authToken}`,
            },
        });

        return {
            pageTotal: response.data.data.last_page,
            currentPage: response.data.data.current_page,
            data: response.data.data.data.map(row => {
                return {
                    ...row,
                    formattedCreatedAt: formattedDate(row.created_at),
                };
            }),
        }


    },
    getById: async function (id) {

        const authToken = getAuthToken();
        return await axios.get(`${config.baseUrl}/api/admin/category/show/${id}`, {
            headers: {
                Authorization: `Bearer ${authToken}`,
            },
        });

    },

    delete: async function (formData) {
        const authToken = getAuthToken();
        const response = await axios.post(`${config.baseUrl}/api/admin/category/delete`, formData, {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                Authorization: `Bearer ${authToken}`,
            },
        });
        return response.data;

    },

    store: async function (formData) {

        const authToken = getAuthToken();
        return await axios.post(`${config.baseUrl}/api/admin/category/store`, formData, {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                Authorization: `Bearer ${authToken}`,
            },
        });
    },


}

export default categoryServices;

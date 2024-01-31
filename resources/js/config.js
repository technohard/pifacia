export const config = {
    baseUrl: process.env.APP_URL,
    imageBaseUrl: process.env.APP_IMAGE_URL,
};
export const isValidEmail = (email) => {
    // Your email validation logic here
    // For simplicity, let's use a basic regular expression
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
};
export const getAuthUser = () => {
    const userAuthData = localStorage.getItem('userAuth');
    return userAuthData ? JSON.parse(userAuthData) : null;
};

export const getAuthToken = () => {
    const authToken = localStorage.getItem('token');
    return authToken ? authToken : null;
};

export const clearAuth = () => {
    const userAuthData = localStorage.getItem('userAuth');
    const authToken = localStorage.getItem('token');
    if(userAuthData){
        localStorage.removeItem('userAuth');
    }
    if(authToken){
        localStorage.removeItem('token');
    }
}


export const formattedDate = (originalDate) => {
    const dateObject = new Date(originalDate);

      const options = {
        day: 'numeric',
        month: 'short',
        year: 'numeric',
        hour: 'numeric',
        minute: 'numeric',
        hour12: true,
      };

      return dateObject.toLocaleString('id-ID', options);
};

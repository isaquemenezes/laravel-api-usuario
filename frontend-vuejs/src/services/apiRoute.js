const baseUrl = 'http://localhost:8000/api';

export const apiRoute = {
  
  usuarios: {
    listar: `${baseUrl}/users`,
    create: `${baseUrl}/users`,   
    edit: (id) => `${baseUrl}/users/${id}`,
    delete: (id) => `${baseUrl}/users/${id}`,
    show: (id) => `${baseUrl}/users/${id}`,
    usuarios_pdf: `${baseUrl}/usuarios/pdf`,
    pdf: (id) => `${baseUrl}/usuarios/${id}/pdf`
  },

 
};
# Use uma imagem oficial do Node.js como imagem base
FROM node:20

# Define o diretório de trabalho dentro do contêiner
WORKDIR /app

# Copia o arquivo package.json e package-lock.json para o diretório de trabalho
COPY ../../client-vuejs/package*.json ./

# Instala as dependências do projeto
RUN npm install

# Copia o código-fonte para o contêiner
COPY ../../client-vuejs .

# Ajusta as permissões dos arquivos
RUN chmod -R 755 /app

# Exponha a porta que o Nginx vai usar
EXPOSE 3000

# # Comando para rodar o Nginx
# CMD ["nginx", "-g", "daemon off;"]
# Comando para iniciar o servidor de desenvolvimento do Vue.js
CMD ["npm", "run", "dev"]
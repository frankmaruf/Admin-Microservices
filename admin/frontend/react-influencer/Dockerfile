FROM node:16.14.2-alpine

WORKDIR /app/frontend
ENV PATH /app/node_modules/.bin:$PATH
COPY package.json ./
COPY package-lock.json ./
RUN npm install
RUN npx browserslist@latest --update-db
COPY . .
EXPOSE 3000
CMD [ "npm", "start" ]
export class Product {
    id: number;
    name: string;
    description: string;
    image: string;
    price: number;

    constructor(id = 0, name = '', description = '', image = '', price = 0) {
        this.id = id;
        this.name = name;
        this.description = description;
        this.image = image;
        this.price = price;
    }
}
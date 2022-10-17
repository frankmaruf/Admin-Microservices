export class User {
    id: number;
    first_name: string;
    last_name: string;
    email: string;
    revenue: number;

    constructor(id = 0, first_name = '', last_name = '', email = '',revenue = 0)
     {
        this.id = id;
        this.first_name = first_name;
        this.last_name = last_name;
        this.email = email;
        this.revenue = revenue;
    }

    get name() {
        return this.first_name + ' ' + this.last_name;
    }
}
import { Categoria } from "./categoria.model";

export class Produto {
  constructor(
    public id: number,
    public nome: string,
    public quantidade: number,
    public categoria: Categoria
  ) { }
}
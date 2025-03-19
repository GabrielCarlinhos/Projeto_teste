import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Produto } from '../models/produto.model';
const headers = new HttpHeaders({
  'Content-Type': 'application/json',
  'Accept': 'application/json',
});

@Injectable({
  providedIn: 'root'
})
export class ProdutoService {
  private apiUrl = 'http://localhost:8080/produto'
  constructor(private http: HttpClient) { }

  findAll() {
    return this.http.get<Produto[]>(this.apiUrl);
  }

  create(model: Produto) {
    return this.http.post<Produto>(`${this.apiUrl}/create`, model, { headers } );
  }

  delete(id: number) {
    return this.http.get<Produto>(`${this.apiUrl}/delete?id=${id}`);
  }

  find(id: number) {
    return this.http.get<Produto>(`${this.apiUrl}/get?id=${id}`);
  }

  update(id: number, model: Produto) {
    return this.http.post<Produto>(`${this.apiUrl}/update?id=${id}`, model, { headers });
  }

}

import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Categoria } from '../models/categoria.model';


@Injectable({
  providedIn: 'root'
})
export class CategoriaService {
  private apiUrl = "http://localhost:8080/categoria"

  constructor(
    private http: HttpClient
  ) { }

  findAll() {
    return this.http.get<Categoria[]>(this.apiUrl);
  }
}

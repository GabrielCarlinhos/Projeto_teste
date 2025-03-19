import { Component, OnInit } from '@angular/core';
import { first } from 'rxjs';
import { Produto } from 'src/app/models/produto.model';
import { ProdutoService } from 'src/app/services/produto.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss']
})
export class HomeComponent implements OnInit {

  public produtos: Produto[] = [];

  constructor(
    private produtoService: ProdutoService,
    private router: Router,
  ) { }

  ngOnInit(): void {
    this.loadProdutos();
  }

  loadProdutos() {
    this.produtoService.findAll().pipe(first()).subscribe({
      next: response => {
        this.produtos = response;
      }
    })
  }

  delete(id: number) {
    if (confirm("Deseja excluir o produto?")) {
      this.produtoService.delete(id).pipe(first()).subscribe({
        next: response => {
          this.loadProdutos();
        }
      })
    }

  }

  edit(id: number) {
    this.router.navigate(['/produto'],{queryParams: {id:id}});
  }

}

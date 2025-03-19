import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { first } from 'rxjs';
import { Categoria } from 'src/app/models/categoria.model';
import { Produto } from 'src/app/models/produto.model';
import { CategoriaService } from 'src/app/services/categoria.service';
import { ProdutoService } from 'src/app/services/produto.service';
import { ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-produto',
  templateUrl: './produto.component.html',
  styleUrls: ['./produto.component.scss']
})
export class ProdutoComponent implements OnInit {
  public id: number = 0;
  public atualizado: boolean = false;
  public cadastrado: boolean = false;
  public form: FormGroup = this.formBuilder.group({});
  public categorias: Categoria[] = [];

  constructor(
    private formBuilder: FormBuilder,
    private categoriaService: CategoriaService,
    private produtoService: ProdutoService,
    private route: ActivatedRoute,
  ) { }

  ngOnInit(): void {
    this.route.queryParams.subscribe(params => {
      this.id = params['id'];
      this.loadProduto();
    })
    this.loadCategorias();
    this.form = this.formBuilder.group({
      nome: [null, Validators.required],
      quantidade: [null, Validators.required],
      categoria: [null, Validators.required],
    })
  }

  onSubmit() {
    if (this.form.invalid) {
      this.atualizado = false;
      this.cadastrado = false;
      this.form.markAllAsTouched();
      return;
    }

    if (this.id > 0) {

      this.produtoService.update(this.id, this.form.value).pipe(first()).subscribe({
        next: response => {
          this.atualizado = true;
        }
      })

    } else {

      this.produtoService.create(this.form.value).pipe(first()).subscribe({
        next: response => {
          this.cadastrado = true;
        }
      })
    }
  }

  loadCategorias() {
    this.categoriaService.findAll().pipe(first()).subscribe({
      next: response => {
        this.categorias = response;
      }
    })
  }

  loadProduto() {
    this.produtoService.find(this.id).pipe(first()).subscribe({
      next: response => {
        this.form.patchValue(response);
      }
    })
  }

}

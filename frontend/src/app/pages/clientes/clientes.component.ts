import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms'; // Importa las clases necesarias para formularios
import { Clientes } from '../models/Clientes.models'; // Asegúrate de tener el modelo adecuado para Clientes
import { ClientesService } from '../service/cliente.service'; // Importa el servicio de clientes
import Swal from 'sweetalert2'; // Importa SweetAlert2 para notificaciones
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule } from '@angular/forms';  // Asegúrate de importar ReactiveFormsModule

@Component({
  selector: 'app-clientes',
  standalone: true,
  imports: [CommonModule,
       ReactiveFormsModule
  ],
  templateUrl: 'Clientes.component.html',
  styleUrls: ['./clientes.component.css'], // Asegúrate de que sea styleUrls en plural
})
export class ClientesComponent implements OnInit {
  cargando: boolean = false;
  listadeClientes:any = [];

  validarFormulario:FormGroup=this.fb.group({
  nombre:['1212',],
  apellido:['121212',],
  correo:['examepl'],
  CI:['21212',],
  direccion:['1212',],
 });

  constructor(
    private fb:FormBuilder,
    private clientesService: ClientesService) {
    this.getClientes();
  }

  ngOnInit(): void {}

  // crearCliente(){
  //   console.log(this.validarFormulario.value);
  //   this.clientesService.crearCliente(this.validarFormulario.value)
  //   .subscribe(resp=>{
  //     console.log(resp);
  //     this.getClientes();
  //   },(error)=>{
  //     console.error(error.error);
  //   })
  // }
  crearCliente() {
    if (this.validarFormulario.invalid) {
        // Si el formulario es inválido, muestra un mensaje de error usando SweetAlert2
        Swal.fire({
            icon: 'warning',
            title: 'Formulario incompleto',
            text: 'Por favor, completa todos los campos obligatorios.',
            confirmButtonText: 'Aceptar'
        });
        return;
    }

    console.log(this.validarFormulario.value);
    this.clientesService.crearCliente(this.validarFormulario.value)
    .subscribe(resp => {
        console.log(resp);
        this.getClientes();
        // Muestra una alerta de éxito si la creación es exitosa
        Swal.fire({
            icon: 'success',
            title: 'Cliente creado',
            text: 'El cliente ha sido creado con éxito.',
            confirmButtonText: 'Aceptar'
        });
    }, error => {
        console.error(error.error);
        // Muestra una alerta de error usando SweetAlert2
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.error.msg || 'Ha ocurrido un error inesperado.',
            confirmButtonText: 'Aceptar'
        });
    });
}



  getClientes() {
    this.cargando = true;

    // Llamar al servicio para obtener la lista de clientes
    this.clientesService.getClientes().subscribe(
      (resp: Clientes[]) => {
        this.listadeClientes = resp;
        console.log(this.listadeClientes);
        this.cargando = false;
      },
      (error) => {
        console.error(error);
        this.cargando = false;
      }
    );
  }
}

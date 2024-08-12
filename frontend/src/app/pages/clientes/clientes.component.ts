import { Component, OnInit } from '@angular/core';
import { EmailValidator, FormBuilder, FormGroup, Validators } from '@angular/forms'; // Importa las clases necesarias para formularios
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

  validarFormulario: FormGroup = this.fb.group({
    nombre: ['', Validators.required],
    apellido: ['', Validators.required],
    numero_documento: ['', [Validators.required]],
    correo: ['', [Validators.required,]],
    direccion: ['', Validators.required],
    nacionalidad: ['', Validators.required],
    procedencia: ['', Validators.required],
    fecha_de_nacimiento: ['', Validators.required],
    estado_civil: ['', Validators.required],
    telefono: ['', [ ]],
    tipo_de_huesped: ['', Validators.required],
    tipo_de_documento: ['', Validators.required],
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
  // crearCliente() {
  //   if (this.validarFormulario.invalid) {
  //     console.log('Formulario inválido:', this.validarFormulario.errors);
  //     Swal.fire({
  //       icon: 'warning',
  //       title: 'Formulario incompleto',
  //       text: 'Por favor, completa todos los campos obligatorios.',
  //       confirmButtonText: 'Aceptar',
  //     });
  //     return;
  //   }

  //   console.log('Formulario válido:', this.validarFormulario.value);

  //   this.clientesService.crearCliente(this.validarFormulario.value).subscribe(
  //     (resp) => {
  //       Swal.fire({
  //         icon: 'success',
  //         title: 'Cliente creado',
  //         text: 'El cliente ha sido creado con éxito.',
  //         confirmButtonText: 'Aceptar',
  //       });
  //       this.getClientes();
  //       this.validarFormulario.reset();
  //     },
  //     (error) => {
  //       console.error('Error al crear cliente:', error);
  //       Swal.fire({
  //         icon: 'error',
  //         title: 'Error',
  //         text: error.error.msg || 'Ha ocurrido un error inesperado.',
  //         confirmButtonText: 'Aceptar',
  //       });
  //     }
  //   );
  // }

  crearCliente() {
    console.log('Estado de cada campo:', this.validarFormulario.controls);

    if (this.validarFormulario.invalid) {
      // Mostrar errores de cada campo
      Object.keys(this.validarFormulario.controls).forEach(field => {
        const control = this.validarFormulario.get(field);
        if (control?.invalid && (control.dirty || control.touched)) {
          console.log(`${field} es inválido. Errores:`, control.errors);
        }
      });

      Swal.fire({
        icon: 'warning',
        title: 'Formulario incompleto',
        text: 'Por favor, completa todos los campos obligatorios.',
        confirmButtonText: 'Aceptar',
      });

      return;
    }

    console.log('Formulario válido:', this.validarFormulario.value);

    this.clientesService.crearCliente(this.validarFormulario.value).subscribe(
      (resp) => {
        Swal.fire({
          icon: 'success',
          title: 'Cliente creado',
          text: 'El cliente ha sido creado con éxito.',
          confirmButtonText: 'Aceptar',
        });
        this.getClientes();
        this.validarFormulario.reset();
      },
      (error) => {
        console.error('Error al crear cliente:', error);
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: error.error?.msg || 'Ha ocurrido un error inesperado.',
          confirmButtonText: 'Aceptar',
        });
      }
    );
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



  eliminarCliente(id: any) {
    this.clientesService.eliminarCliente(id)
      .subscribe(resp => {
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Cliente eliminado',
          text: 'El cliente ha sido eliminado con éxito.',
          showConfirmButton: false,
          timer: 1500
        });
        this.getClientes();
      }, (error) => {
        console.log(error);
      });
  }

}

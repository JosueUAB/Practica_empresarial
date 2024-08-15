import { Component, OnInit } from '@angular/core';
import { EmailValidator, FormBuilder, FormGroup, Validators } from '@angular/forms'; // Importa las clases necesarias para formularios
import { Clientes } from '../models/Clientes.models'; // Asegúrate de tener el modelo adecuado para Clientes
import { ClientesService } from '../service/cliente.service'; // Importa el servicio de clientes
import Swal from 'sweetalert2'; // Importa SweetAlert2 para notificaciones
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule } from '@angular/forms';  // Asegúrate de importar ReactiveFormsModule
import { RouterModule } from '@angular/router';
import { Modal } from 'flowbite';


@Component({
  selector: 'app-clientes',
  standalone: true,
  imports: [CommonModule,
       ReactiveFormsModule,


  ],
  templateUrl: 'Clientes.component.html',
  styleUrls: ['./clientes.component.css'], // Asegúrate de que sea styleUrls en plural
})
export class ClientesComponent implements OnInit {
  cargando: boolean = false;
  listadeClientes:any = [];
  ModalCrearCliente=false;
  ModalActualizarCliente=false;
  ModalVerCliente:boolean=false;
  esSoloLectura: boolean = true;
  botonguardar:boolean = false;

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
    id:['']
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
        this.CerrarModalCrearCliente();
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
  eliminarClienteModal(clienteId: string) {
    Swal.fire({
      title: '¿Estás seguro?',
      text: 'Una vez eliminado, ¡no podrás recuperar este cliente!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, eliminar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        this.clientesService.eliminarCliente(clienteId).subscribe(
          response => {
            Swal.fire({
              icon: 'success',
              title: 'Cliente eliminado exitosamente',
              text: 'El cliente ha sido eliminado correctamente.',
              confirmButtonText: 'Aceptar'
            }).then(() => {
              // Puedes hacer alguna acción adicional aquí, como actualizar la lista de clientes o redirigir
              this.getClientes(); // Asumiendo que tienes un método para obtener la lista actualizada de clientes
            });
          },
          error => {
            Swal.fire({
              icon: 'error',
              title: 'Error al eliminar cliente',
              text: 'Hubo un problema al intentar eliminar el cliente. Inténtalo de nuevo más tarde.',
              confirmButtonText: 'Aceptar'
            });
          }
        );
      }
    });
  }



  abrirModalCrearCliente() {
    this.ModalCrearCliente = true;

  }
  CerrarModalCrearCliente() {
    this.ModalCrearCliente = false;
  }
  abrirModalVerCliente(id:any){
   this.ModalVerCliente = true;
   this.esSoloLectura = true;
    this.clientesService.detallesCliente(id).subscribe(
      (response: any) => {
        const cliente = response.cliente;
        this.validarFormulario.patchValue(cliente);
        console.log(this.validarFormulario.value);
      },
      (error) => {
        console.error('Error al cargar detalles del cliente:', error);
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'No se pudieron cargar los detalles del cliente.',
          confirmButtonText: 'Aceptar',
        });
      }
    );
  }
  cerrarModalVerCliente() {
    this.ModalVerCliente = false;
    this.botonguardar=false;
    this.validarFormulario.reset();

  }


  actualizarCliente() {
    if (this.validarFormulario.valid) {
      const cliente: Clientes = this.validarFormulario.value;

      this.clientesService.editarCliente(cliente).subscribe(

        response => {
          Swal.fire({
            icon: 'success',
            title: 'Cliente actualizado exitosamente',
            text: 'Los datos del cliente se han actualizado correctamente.',
            confirmButtonText: 'Aceptar'
          }).then(() => {
            // Puedes hacer alguna acción adicional aquí, como redirigir o limpiar el formulario
          });
          this.getClientes();
          this.validarFormulario.reset();

        },
        error => {
          Swal.fire({
            icon: 'error',
            title: 'Error al actualizar cliente',
            text: 'Hubo un problema al intentar actualizar el cliente. Inténtalo de nuevo más tarde.',
            confirmButtonText: 'Aceptar'
          });
        }
      );
    }

    else {
      Swal.fire({
        icon: 'warning',
        title: 'Formulario inválido',
        text: 'Por favor, completa todos los campos requeridos.',
        confirmButtonText: 'Aceptar'
      });
    }
    this.botonguardar=false;
    this.cerrarModalVerCliente();
  }


  CerrarModalActualizarCliente() {
    this.ModalActualizarCliente = false;
    this.botonguardar=false;
  }

  editarinmput(){
    this.esSoloLectura = false;
    this.botonguardar = true;
  }


}

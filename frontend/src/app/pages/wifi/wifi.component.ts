import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms'; // Importa las clases necesarias para formularios
import { Wifi } from '../models/wifi.model'; // Asegúrate de tener el modelo adecuado para Wifi
import { WifiService } from '../service/wifi.service'; // Importa el servicio de Wi-Fi
import Swal from 'sweetalert2'; // Importa SweetAlert2 para notificaciones
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule } from '@angular/forms';  // Asegúrate de importar ReactiveFormsModule
import { RouterModule } from '@angular/router';

@Component({
  selector: 'app-wifi',
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule],
  templateUrl: './wifi.component.html',
  styleUrls: ['./wifi.component.scss'], // Asegúrate de que sea styleUrls en plural
})
export class WifiComponent implements OnInit {
  cargando: boolean = false;
  listaDeWifi: any = [];
  ModalCrearWifi = false;
  ModalActualizarWifi = false;
  ModalVerWifi = false;
  esSoloLectura: boolean = true;
  botonguardar: boolean = false;

  validarFormulario: FormGroup = this.fb.group({
    ssid: ['', Validators.required],
    contrasena: ['', Validators.required],
    piso: ['', Validators.required],
    id: ['']
  });

  constructor(
    private fb: FormBuilder,
    private wifiService: WifiService
  ) {
    this.getWifi();
  }

  ngOnInit(): void {
    this.getWifi();

  }

  // Crear red Wi-Fi
  crearWifi() {
    if (this.validarFormulario.invalid) {
      Swal.fire({
        icon: 'warning',
        title: 'Formulario incompleto',
        text: 'Por favor, completa todos los campos obligatorios.',
        confirmButtonText: 'Aceptar',
      });
      return;
    }

    this.wifiService.crearWifi(this.validarFormulario.value).subscribe(
      (resp) => {
        Swal.fire({
          icon: 'success',
          title: 'Red Wi-Fi creada',
          text: 'La red Wi-Fi ha sido creada con éxito.',
          confirmButtonText: 'Aceptar',
        });
        this.getWifi();
        this.cerrarModalCrearWifi();
        this.validarFormulario.reset();
      },
      (error) => {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: error.error?.msg || 'Ha ocurrido un error inesperado.',
          confirmButtonText: 'Aceptar',
        });
      }
    );
  }

  // Obtener la lista de redes Wi-Fi
  getWifi() {
    this.cargando = true;

    this.wifiService.getWifi().subscribe(
      (resp: Wifi[]) => {
        this.listaDeWifi = resp;
        this.cargando = false;
        console.log(this.listaDeWifi);
      },
      (error) => {

        this.cargando = false;
      }
    );
  }

  // Ver detalles de una red Wi-Fi
  abrirModalVerWifi(id: string) {
    this.ModalVerWifi = true;
    this.esSoloLectura = true;

    this.wifiService.detallesWifi(id).subscribe(
      (response: Wifi) => {
        this.validarFormulario.patchValue(response);
      },
      (error) => {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'No se pudieron cargar los detalles de la red Wi-Fi.',
          confirmButtonText: 'Aceptar',
        });
      }
    );
  }

  // Cerrar el modal de ver Wi-Fi
  cerrarModalVerWifi() {
    this.ModalVerWifi = false;
    this.botonguardar = false;
    this.validarFormulario.reset();
  }

  // Actualizar red Wi-Fi
  actualizarWifi() {
    if (this.validarFormulario.invalid) {
      Swal.fire({
        icon: 'warning',
        title: 'Formulario inválido',
        text: 'Por favor, completa todos los campos requeridos.',
        confirmButtonText: 'Aceptar',
      });
      return;
    }

    const wifi: Wifi = this.validarFormulario.value;

    this.wifiService.editarWifi(wifi).subscribe(
      (response) => {
        Swal.fire({
          icon: 'success',
          title: 'Red Wi-Fi actualizada',
          text: 'Los datos de la red Wi-Fi se han actualizado correctamente.',
          confirmButtonText: 'Aceptar',
        }).then(() => {
          this.getWifi();
          this.validarFormulario.reset();
          this.cerrarModalActualizarWifi();
        });
      },
      (error) => {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Hubo un problema al intentar actualizar la red Wi-Fi.',
          confirmButtonText: 'Aceptar',
        });
      }
    );
  }

  // Eliminar red Wi-Fi
  eliminarWifiModal(wifiId: string) {
    Swal.fire({
      title: '¿Estás seguro?',
      text: 'Una vez eliminado, ¡no podrás recuperar esta red Wi-Fi!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, eliminar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        this.wifiService.eliminarWifi(wifiId).subscribe(
          () => {
            Swal.fire({
              icon: 'success',
              title: 'Red Wi-Fi eliminada exitosamente',
              text: 'La red Wi-Fi ha sido eliminada correctamente.',
              confirmButtonText: 'Aceptar'
            }).then(() => {
              this.getWifi();

            });
            this.getWifi();
          },
          (error) => {
            Swal.fire({
              icon: 'error',
              title: 'Error al eliminar red Wi-Fi',
              text: 'Hubo un problema al intentar eliminar la red Wi-Fi.',
              confirmButtonText: 'Aceptar'
            });
          }
        );
        this.getWifi();
      }
    });
  }

  // Abrir modal para crear red Wi-Fi
  abrirModalCrearWifi() {
    this.ModalCrearWifi = true;
  }

  // Cerrar modal de crear red Wi-Fi
  cerrarModalCrearWifi() {
    this.ModalCrearWifi = false;
  }

  // Abrir modal para actualizar red Wi-Fi
  abrirModalActualizarWifi(id: string) {
    this.ModalActualizarWifi = true;
    this.esSoloLectura = false;
    this.botonguardar = true;

    this.wifiService.detallesWifi(id).subscribe(
      (response: Wifi) => {
        this.validarFormulario.patchValue(response);
      },
      (error) => {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'No se pudieron cargar los detalles de la red Wi-Fi.',
          confirmButtonText: 'Aceptar',
        });
      }
    );
  }

  // Cerrar modal de actualizar red Wi-Fi
  cerrarModalActualizarWifi() {
    this.ModalActualizarWifi = false;
    this.botonguardar = false;
    this.validarFormulario.reset();
  }

  // Hacer el formulario editable
  editarFormulario() {
    this.esSoloLectura = false;
    this.botonguardar = true;
  }
}

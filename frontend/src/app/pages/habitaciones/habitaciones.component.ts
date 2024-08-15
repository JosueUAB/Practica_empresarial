import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Habitacion } from '../models/Habitaciones.models';
import { HabitacionService } from '../service/habitaciones.service'; // Asegúrate de importar el servicio adecuado
import Swal from 'sweetalert2';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule } from '@angular/forms';
import { RouterModule } from '@angular/router';
import { WifiService } from '../service/wifi.service';
import { Wifi } from '../models/wifi.model'; // Asegúrate de importar el modelo adecuado

@Component({
  selector: 'app-habitaciones',
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule, RouterModule],
  templateUrl: './habitaciones.component.html',
  styleUrls: ['./habitaciones.component.scss']
})
export class HabitacionesComponent implements OnInit {
  cargando: boolean = false;

  listaDeWifi: any = []; // Lista para los Wi-Fi
  listadeHabitaciones: any = [];
  ModalCrearHabitacion = false;
  ModalActualizarHabitacion = false;
  ModalVerHabitacion = false;
  esSoloLectura: boolean = true;
  botonguardar: boolean = false;

  validarFormulario: FormGroup = this.fb.group({
    numero_piso:['',Validators.required],
    numero: ['', Validators.required],
    tipo: ['', Validators.required],
    cantidad_camas: ['', [Validators.required]],
    limite_personas: ['', Validators.required],
    costo: ['', Validators.required],
    tv: [false],    // Valor predeterminado de false
  ducha: [false], // Valor predeterminado de false
  baño: [false],  // Valor predeterminado de false

    estado: ['', Validators.required],
    wifi_id: [''],
    descripcion: [''],
    id: ['']
  });

  constructor(
    private fb: FormBuilder,
    private habitacionService: HabitacionService,
    private wifiService: WifiService // Inyecta el servicio de Wi-Fi
  ) {}

  ngOnInit(): void {
    this.getHabitaciones();
    this.getWifi(); // Obtener la lista de Wi-Fi
  }

  // Obtener la lista de Wi-Fi
  getWifi() {
    this.wifiService.getWifi().subscribe(
      (resp: Wifi[]) => {
        this.listaDeWifi = resp;
        console.log(this.listaDeWifi);
      },
      (error) => {
        console.error(error);

      }
    );
  }
// Crear habitación
crearHabitacion() {
  if (this.validarFormulario.invalid) {
    Swal.fire({
      icon: 'warning',
      title: 'Formulario incompleto',
      text: 'Por favor, completa todos los campos obligatorios.',
      confirmButtonText: 'Aceptar'
    });
    return;
  }

  // Obtener los valores del formulario
  const formData = this.validarFormulario.value;

  // Asegúrate de que los valores nulos se cambien a false
  formData.ducha = formData.ducha ?? false;
  formData.baño = formData.baño ?? false;
  formData.tv = formData.tv ?? false;

  // Log para verificar los valores antes del envío
  console.log(formData);

  // Enviar datos al backend
  this.habitacionService.crearHabitacion(formData).subscribe(
    (resp) => {
      Swal.fire({
        icon: 'success',
        title: 'Habitación creada',
        text: 'La habitación ha sido creada con éxito.',
        confirmButtonText: 'Aceptar'
      });
      this.getHabitaciones();
      this.CerrarModalCrearHabitacion();
      this.validarFormulario.reset();
    },
    (error) => {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: error.error?.msg || 'Ha ocurrido un error inesperado.',
        confirmButtonText: 'Aceptar'
      });
    }
  );
}



  getHabitaciones() {
    this.cargando = true;
    this.habitacionService.getHabitaciones().subscribe(
      (resp) => {
        this.listadeHabitaciones = resp;
        console.log(this.listadeHabitaciones);
        this.cargando = false;
      },
      (error) => {
        console.error(error);
        this.cargando = false;
      }
    );
  }

  eliminarHabitacionModal(habitacionId: string) {
    Swal.fire({
      title: '¿Estás seguro?',
      text: 'Una vez eliminado, ¡no podrás recuperar esta habitación!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, eliminar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        this.habitacionService.eliminarHabitacion(habitacionId).subscribe(
          () => {
            Swal.fire({
              icon: 'success',
              title: 'Habitación eliminada',
              text: 'La habitación ha sido eliminada con éxito.',
              confirmButtonText: 'Aceptar'
            }).then(() => {
              this.getHabitaciones();
            });
          },
          (error) => {
            Swal.fire({
              icon: 'error',
              title: 'Error al eliminar',
              text: 'Hubo un problema al intentar eliminar la habitación. Inténtalo de nuevo más tarde.',
              confirmButtonText: 'Aceptar'
            });
          }
        );
      }
    });
  }

  abrirModalCrearHabitacion() {
    this.ModalCrearHabitacion = true;
  }

  CerrarModalCrearHabitacion() {
    this.ModalCrearHabitacion = false;
  }

  abrirModalVerHabitacion(id: string) {
    this.ModalVerHabitacion = true;
    this.esSoloLectura = true;
    this.habitacionService.detallesHabitacion(id).subscribe(
      (response: any) => {
        const habitacion = response;
        this.validarFormulario.patchValue(habitacion);
      },
      (error) => {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'No se pudieron cargar los detalles de la habitación.',
          confirmButtonText: 'Aceptar'
        });
      }
    );
  }

  cerrarModalVerHabitacion() {
    this.ModalVerHabitacion = false;
    this.botonguardar = false;
    this.validarFormulario.reset();
  }

  actualizarHabitacion() {
    if (this.validarFormulario.valid) {
      const habitacion: Habitacion = this.validarFormulario.value;
      this.habitacionService.editarHabitacion(habitacion).subscribe(
        () => {
          Swal.fire({
            icon: 'success',
            title: 'Habitación actualizada',
            text: 'Los datos de la habitación se han actualizado correctamente.',
            confirmButtonText: 'Aceptar'
          }).then(() => {
            this.getHabitaciones();
            this.validarFormulario.reset();
          });
        },
        (error) => {
          Swal.fire({
            icon: 'error',
            title: 'Error al actualizar',
            text: 'Hubo un problema al intentar actualizar la habitación. Inténtalo de nuevo más tarde.',
            confirmButtonText: 'Aceptar'
          });
        }
      );
    } else {
      Swal.fire({
        icon: 'warning',
        title: 'Formulario inválido',
        text: 'Por favor, completa todos los campos requeridos.',
        confirmButtonText: 'Aceptar'
      });
    }
    this.botonguardar = false;
    this.cerrarModalVerHabitacion();
  }

  CerrarModalActualizarHabitacion() {
    this.ModalActualizarHabitacion = false;
    this.botonguardar = false;
  }

  editarInput() {
    this.esSoloLectura = false;
    this.botonguardar = true;
  }
}


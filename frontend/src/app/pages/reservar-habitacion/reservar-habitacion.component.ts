import { Component } from '@angular/core';

import { ReservaService } from '../service/reserva.service';
import { FormBuilder, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { ActivatedRoute, RouterModule } from '@angular/router';
import { Clientes } from '../models/Clientes.models'; // Asegúrate de tener el modelo adecuado para Clientes
import { ClientesService } from '../service/cliente.service'; // Importa el servicio de clientes
import { Reservas } from '../models/ReservarHabitaciones.model';
import { ReservarhabitacionService } from '../service/reservarhabitacion.service';
import { Habitacion } from '../models/Habitaciones.models';
import { HabitacionService } from '../service/habitaciones.service';
import Swal from 'sweetalert2';
import { ListaReservasComponent } from '../lista-reservas/lista-reservas.component';

@Component({
  selector: 'app-reservar-habitacion',
  standalone: true,
  imports: [
    CommonModule,
    RouterModule,
    ReactiveFormsModule,
    ListaReservasComponent
  ],
  templateUrl: './reservar-habitacion.component.html',
  styleUrl: './reservar-habitacion.component.scss'
})
export class ReservarHabitacionComponent {
  listadeClientes:any = [];
  listadeHabitaciones: any = [];
  listadeReservas:any = [];
  reserva: { valor1: any, valor2: any } | null = null;
  cargando: boolean = false;
  cargandoHabitaciones: boolean = false;
  cargandoReservas:boolean = false;
  habitacion: Habitacion | undefined;
  error: string | undefined;
  habitacionId: string = '1'; // Valor real para enviar
  habitacionIdDisplay: string = 'Valor a Mostrar'; // Valor a mostrar en el input

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
  validarFormularioReservas = this.fb.group({
    cliente_id: ['', Validators.required],
    habitacion_id: ['', [Validators.required]],
    fecha_inicio: ['', Validators.required],
    fecha_fin: ['', Validators.required],
    numero_personas: ['', [Validators.required, Validators.min(1)]],
    adelanto: ['', [Validators.required, Validators.min(0)]],
    tipo_comprobante: ['', Validators.required]
  });

  constructor(
    private fb:FormBuilder,
    private reservaService: ReservaService , // Inject the service into the component
    private clientesService: ClientesService,
    private route: ActivatedRoute,
    private habitacionService: HabitacionService,
    private reservarhabiacionesService:ReservarhabitacionService,
  ) {
    this.getClientes(); // Obtener la lista de clientes al iniciar el componente
    this.getHabitaciones(); // Obtener
    this.getReservas();
  }


  ngOnInit(): void {
    this.reservaService.reserva$.subscribe(reserva => {
      if (reserva) {
        // Actualiza el FormControl directamente
        this.validarFormularioReservas.patchValue({
          habitacion_id: reserva.valor1 // Asegúrate de que valor1 tenga el ID de la habitación
        });

        // También puedes actualizar otras variables si es necesario
        this.habitacionIdDisplay = reserva.valor2; // Valor a mostrar
      }
    });

    this.route.paramMap.subscribe(params => {
      const id = params.get('id');
      if (id) {
        this.obtenerDetallesHabitacion(id);
      }
    });

  }

  getHabitaciones() {
    this.cargandoHabitaciones = true;
    this.habitacionService.getHabitaciones().subscribe(
      (resp) => {
        this.listadeHabitaciones = resp;
        console.log(this.listadeHabitaciones);
        this.cargandoHabitaciones = false;
      },
      (error) => {
        console.error(error);
        this.cargandoHabitaciones = false;
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
  getReservas() {
    this.reservarhabiacionesService.getReservas().subscribe(
      (resp: Reservas[]) => {
        this.listadeReservas = resp;
        console.log(this.listadeReservas);
      },
      (error) => {
        console.error(error);
      }
    );
  }


  CerrarModalCrearCliente(){

  }
  crearCliente() {
    const cliente = this.validarFormulario.value;
    this.clientesService.crearCliente(cliente).subscribe(
      () => {
        Swal.fire('Éxito', 'Cliente creado con éxito', 'success');
        this.getClientes(); // Actualiza la lista de clientes
        this.validarFormulario.reset(); // Limpia el formulario
      },
      (error) => {
        console.error(error);
        Swal.fire('Error', 'Error al crear cliente', 'error');
      }
    );
  }
  crearReserva() {
    const reserva = this.validarFormularioReservas.value;
    console.log(this.validarFormularioReservas.value)
    this.reservarhabiacionesService.crearReserva(reserva).subscribe(
      () => {
        Swal.fire('Éxito', 'Reserva creada con éxito', 'success');
        this.getReservas(); // Actualiza la lista de reservas
        this.validarFormularioReservas.reset(); // Limpia el formulario
      },
      (error) => {
        console.error(error);
        Swal.fire('Error', 'Error al crear reserva', 'error');
      }
    );
  }
  editarReserva(reserva: Reservas) {
    this.validarFormularioReservas.patchValue(reserva);
  }

  eliminarReserva(id: string) {
    Swal.fire({
      title: '¿Estás seguro?',
      text: 'Una vez eliminada, no podrás recuperar esta reserva.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, eliminar'
    }).then((result) => {
      if (result.isConfirmed) {
        this.reservarhabiacionesService.eliminarReserva(id).subscribe(
          () => {
            Swal.fire('Eliminado', 'Reserva eliminada con éxito', 'success');
            this.getReservas(); // Actualiza la lista de reservas
          },
          (error) => {
            console.error(error);
            Swal.fire('Error', 'Error al eliminar reserva', 'error');
          }
        );
      }
    });
  }

  obtenerDetallesHabitacion(id: string) {
    this.cargando = true;
    this.habitacionService.detallesHabitacion(id).subscribe(
      (data: Habitacion) => {
        this.habitacion = data;
        this.cargando = false;
        console.log(this.habitacion)
      },
      (error) => {
        console.error('Error al obtener los detalles de la habitación:', error);
        this.error = 'No se pudo obtener la información de la habitación.';
        this.cargando = false;
        Swal.fire('Error', 'No se pudo obtener la información de la habitación.', 'error');
      }
    );
  }

}

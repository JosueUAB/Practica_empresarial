import { Component } from '@angular/core';
import { ReservarhabitacionService } from '../service/reservarhabitacion.service';
import { Reservas } from '../models/ReservarHabitaciones.model';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';
import { ReactiveFormsModule } from '@angular/forms';
import pdfMake from 'pdfmake/build/pdfmake';
import pdfFonts from 'pdfmake/build/vfs_fonts';

pdfMake.vfs = pdfFonts.pdfMake.vfs;





@Component({
  selector: 'app-lista-reservas',
  standalone: true,
  imports: [
    CommonModule,
    RouterModule,
    ReactiveFormsModule
  ],
  templateUrl: './lista-reservas.component.html',
  styleUrl: './lista-reservas.component.scss'
})
export class ListaReservasComponent {
  listadeReservas:any=[];

  constructor(
    private reservarhabiacionesService:ReservarhabitacionService,
  ){

    this.getReservashabitaciones();
  }



  getReservashabitaciones() {
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

  imprimirticket(reservaId: number) {
    this.reservarhabiacionesService.getReservaPorId(reservaId.toString()).subscribe(
      (response: any) => {
        const reserva = response.reserva;

        const docDefinition = {
          pageSize: {
            width: 80 * 2.83, // 80mm en puntos
            height: 297 * 2.83 // 297mm en puntos
          },
          pageMargins: [4, 10, 4, 10],
          content: [
            { text: 'Alojamiento Emilio', style: 'header' },
            { text: 'NIT: 0000000000', style: 'subHeader' },
            { text: 'Dirección ORURO , Calle bolivar entre backociv y 6 de agosto', style: 'subHeader' },
            { text: 'Teléfono: 00000000', style: 'subHeader' },
            { text: 'Email: EmilioNET@gmail.com', style: 'subHeader' },

            { text: '------------------------------------------------------', style: 'line' },

            { text: `Fecha: ${new Date().toLocaleDateString()} ${new Date().toLocaleTimeString()}`, style: 'info' },
            { text: 'Recepcionista Nro: 1', style: 'info' },
            { text: 'usuario', style: 'info' },
            { text: `Ticket Nro: ${reserva.id}`, style: 'ticketNumber' },

            { text: '------------------------------------------------------', style: 'line' },

            { text: `Cliente: ${reserva.cliente.nombre} ${reserva.cliente.apellido}`, style: 'info' },
            { text: `Documento: ${reserva.cliente.tipo_de_documento} ${reserva.cliente.numero_documento}`, style: 'info' },
            { text: `Teléfono: ${reserva.cliente.telefono}`, style: 'info' },
            { text: `Dirección: ${reserva.cliente.direccion}`, style: 'info' },

            { text: '-------------------------------------------------------------------', style: 'line' },

            {
              table: {
                widths: [20, 50, 30, 40],
                body: [
                  [{ text: 'Fecha Inicio', style: 'tableHeader' }, { text: 'Fecha Fin', style: 'tableHeader' }, { text: 'Tarifa', style: 'tableHeader' }, { text: 'Saldo', style: 'tableHeader' }],
                  [
                    { text: reserva.fecha_inicio, style: 'tableData' },
                    { text: reserva.fecha_fin, style: 'tableData' },
                    { text: `$${reserva.tarifa} USD`, style: 'tableData' },
                    { text: `$${reserva.saldo} USD`, style: 'tableData' }
                  ],
                  [{ text: `Número de Personas: ${reserva.numero_personas}`, colSpan: 4, style: 'tableData' }, {}, {}, {}],
                  [{ text: `Tipo de Comprobante: ${reserva.tipo_comprobante}`, colSpan: 4, style: 'tableData' }, {}, {}, {}]
                ]
              },
              layout: 'noBorders'
            },

            { text: '-------------------------------------------------------------------', style: 'line' },

            { text: 'SUBTOTAL', style: 'summary' },
            { text: `+ $${reserva.tarifa} USD`, style: 'summaryValue' },



            { text: '-------------------------------------------------------------------', style: 'line' },

            { text: 'TOTAL A PAGAR', style: 'summary' },
            { text: `$${reserva.tarifa} USD`, style: 'summaryValue' },

            { text: 'TOTAL PAGADO', style: 'summary' },
            { text: `$${reserva.tarifa} USD`, style: 'summaryValue' },

            { text: '*** Para poder realizar un reclamo o devolución debe presentar este ticket ***', style: 'footer' },

            { text: 'Gracias por su estadia', style: 'thanks' },

            // Código de barras (simulado, ya que pdfmake no tiene soporte directo para Code128)
            { text: `COD${reserva.id}`, style: 'barcode' }
          ],
          styles: {
            header: { fontSize: 10, bold: true, alignment: 'center' },
            subHeader: { fontSize: 9, alignment: 'center' },
            info: { fontSize: 9, alignment: 'center' },
            ticketNumber: { fontSize: 10, bold: true, alignment: 'center' },
            line: { fontSize: 8, alignment: 'center' },
            tableHeader: { fontSize: 9, bold: true, alignment: 'center' },
            tableData: { fontSize: 9, alignment: 'center' },
            summary: { fontSize: 9, alignment: 'right' },
            summaryValue: { fontSize: 9, alignment: 'right' },
            footer: { fontSize: 8, alignment: 'center' },
            thanks: { fontSize: 9, bold: true, alignment: 'center' },
            barcode: { fontSize: 12, alignment: 'center' }
          }
        };

        pdfMake.createPdf(docDefinition).download(`Ticket_${reserva.id}.pdf`);
      },
      (error) => {
        console.error('Error al obtener la reserva:', error);
      }
    );
  }

  }



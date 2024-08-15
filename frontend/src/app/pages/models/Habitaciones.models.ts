export class Habitacion
{
  constructor(
   numero_piso:number,
    numero: string,
    tipo: 'individual' | 'doble' | 'colectiva' | 'matrimonial' | 'familiar',
    cantidad_camas: number,
    limite_personas: number,
    costo: number,
    tv: boolean,
    ducha: boolean,
    banio: boolean,
    disponible: boolean,
    estado: 'disponible' | 'mantenimiento' | 'limpieza'| 'ocupado'| 'reservado',
    wifi_id?: number,
    descripcion?: string,
    id?: string
  ){}
}

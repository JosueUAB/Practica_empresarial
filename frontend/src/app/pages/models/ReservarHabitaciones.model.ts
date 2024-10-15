export class Reservas
{
  constructor(

      cliente_id: number,
      habitacion_id: number,
      fecha_inicio: Date, // O puedes usar Date si prefieres manejar fechas como objetos Date
      fecha_fin: Date, // O puedes usar Date si prefieres manejar fechas como objetos Date
      numero_personas: number,
      adelanto: number,
      tipo_comprobante: string,
      saldo?: number, // Campo opcional
      tarifa?: number, // Campo opcional
       // Puedes ajustar los valores permitidos según tu aplicación
      id?: string

  ){}
}

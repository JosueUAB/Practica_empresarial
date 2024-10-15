declare module 'qrcode' {
  export function toDataURL(text: string, options?: any): Promise<string>;
  export function toFile(filePath: string, text: string, options?: any): Promise<void>;
  // Agrega más funciones según lo que uses del módulo
}

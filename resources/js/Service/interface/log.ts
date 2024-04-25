export default interface Log {
  error: (data: unknown, methodName: string) => void;
  info: (data: unknown, methodName: string) => void;
  warn: (data: unknown, methodName: string) => void;
}

import Log from "../interface/log";

export default {
  error: (data: unknown, methodName: string) => {
    console.info(`[Error] ${methodName}`, data);
  },
  info: (data: unknown, methodName: string) => {
    console.info(`[Info] ${methodName}`, data);
  },
  warn: (data: unknown, methodName: string) => {
    console.info(`[Warn] ${methodName}`, data);
  },
} as Log;

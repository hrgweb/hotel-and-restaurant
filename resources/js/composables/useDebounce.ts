export function useDebounce(callback: any, delay: number = 500) {
  let timeoutId: any

  const execute = (...args: any) => {
    clearTimeout(timeoutId)
    timeoutId = setTimeout(() => {
      callback(...args)
    }, delay)
  }

  return {
    execute,
  }
}

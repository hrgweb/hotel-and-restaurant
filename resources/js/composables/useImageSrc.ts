export function useImageSrc(thumbnail: string): string | null {
  return thumbnail ? `/storage/uploads/${thumbnail}` : null
}

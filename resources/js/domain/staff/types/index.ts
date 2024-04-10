import { Role } from '@/role/types'

type User = {
  id?: number
  first_name: string
  last_name: string
  email: string
  username: string
  gender: string
  dob: string
}

type Staff = {
  id?: number
  role: Role
  user: User
}

export type { Staff, User }

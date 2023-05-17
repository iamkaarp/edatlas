export interface System {
  id: number
  address: number
  name: string
  population: number
  distance: number
  x: number
  y: number
  z: number
  economy: string
  second_economy: string
  government: string
  security: string
  allegiance: string
  powers: JSON
  pps: string
  updated_at: string
}

export interface Systems {
  data: System[]
  current_page: number
  from: number
  last_page: number
  per_page: number
  to: number
  total: number
}

import axios, { Axios, AxiosError } from 'axios'
import { string } from '@poppinss/utils/build/helpers'

class HTTP {
  http: Axios = axios.create({
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    },
  })

  public root = `http.api`

  public async index(page: number = 1, column: string = 'id', order: string = 'asc'): Promise<any> {
    console.log(this.root)
    const systems = await this.http.get(
      route(`${this.root}.index`, { page: page, sort: column, order: order })
    )
    return systems.data
  }

  public async get(name: string): Promise<any> {
    const data = await this.http.get(route(`${this.root}.show`, { name }))
    return data
  }

  public async filter(
    page: number = 1,
    column: string = 'id',
    order: string = 'asc',
    filter: any
  ): Promise<any> {
    try {
      const systems = await this.http.get(
        route(`${this.root}.filter`, {
          page: page,
          sort: column,
          order: order,
          filters: filter,
        })
      )
      return systems.data
    } catch (e: any | AxiosError) {
      return e.response.data
    }
  }
}

export default HTTP

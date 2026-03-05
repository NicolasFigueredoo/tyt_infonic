import Layout from './Layout.vue'

import Home   from './Home.vue'

import { routes as articulosRoutes } from '../articulos/config'

import { routes as InformacionTecnica } from '../informacionTecnica/config'

import { routes as clienteRoutes } from '../cliente/config'

import { routes as clienteTempRoutes } from '../clienteTemp/config'

import { routes as TipoArticuloRoutes } from '../tipo-articulo/config'

import { routes as EmpresaRoutes } from '../empresa/config'

import { routes as CalidadRoutes } from '../calidad/config'

import { routes as InicioRoutes } from '../inicio/config'

import { routes as NovedadRoutes } from '../novedad/config'

import { routes as ContactoRoutes } from '../contacto/config'

import { routes as CarritoRoutes } from '../carrito/config'

import { routes as ModalRoutes } from '../modal/config'

import { routes as LogoRoutes } from '../logo/config'

import { routes as RedesRoutes } from '../redes/config'

import { routes as SeccionesRoutes } from '../secciones/config'

import { routes as LogosRoutes } from '../logos/config'

import { routes as SliderRoutes } from '../slider/config'



import { routes as MetadatosRoutes } from '../metadatos/config'

import { routes as VendedoresRoutes } from '../vendedores/config'

import { routes as ComoComprarRoutes } from '../comoComprar/config'

import { routes as PedidosRoutes } from '../pedidos/config'

import { routes as TutorialesRoutes } from '../tutoriales/config'

import { routes as SubCategoriaRoutes } from '../sub-categoria/config'

import { routes as ListaPreciosRoutes } from '../listaPrecios/config'

import { routes as ClientesPotenciales } from '../clientesPotenciales/config'

import { routes as FormClientesRoutes } from '../formularioClientes/config'

import { routes as ArchivosMedia } from '../archivosMedia/config'


import { routes as Metricas } from '../metricas/config'







export const routes = {

    path: '/adm/data',

    name: 'data',

    meta: {

        displayName: 'Maestros / Catálogos',

    },

    component: Layout,

    children: [

        {

            path: '',

            name: 'data-home',

            component: Home

        },

        articulosRoutes,

        InformacionTecnica,

        clienteRoutes,

        clienteTempRoutes,

        TipoArticuloRoutes,

        EmpresaRoutes,

        CalidadRoutes,

        InicioRoutes,        

        NovedadRoutes,

        ContactoRoutes,

        CarritoRoutes,

        ModalRoutes,

        LogoRoutes,

        RedesRoutes,

        MetadatosRoutes,

        VendedoresRoutes,

        ComoComprarRoutes,

        PedidosRoutes,

        TutorialesRoutes,

        SubCategoriaRoutes,

        SeccionesRoutes,

        LogosRoutes,

        SliderRoutes,

        ListaPreciosRoutes,

        ClientesPotenciales,

        Metricas,

        FormClientesRoutes,

        ArchivosMedia

        

    ],

}
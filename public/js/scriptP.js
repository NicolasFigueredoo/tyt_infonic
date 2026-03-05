console.log('scriptGa4.js cargado correctamente');



window.myCartModule = {

  // Actualiza la marca de tiempo del carrito

  setCartTimestamp: function () {

    localStorage.setItem('cart_last_update', Date.now());

    // Al actualizar el carrito, eliminamos cualquier bandera de abandono previo

    localStorage.removeItem('cart_abandoned');

  },



  // Verifica en cada carga de página si el carrito fue abandonado

  checkCartAbandonment: function () {

    console.log('se ingreso');



    const lastUpdate = localStorage.getItem('cart_last_update');

    // Para pruebas, podrías usar un valor menor,

    // pero supongamos que:

    // 24 horas = 86400000 ms, 48 horas = 172800000 ms

    if (lastUpdate) {

      const diff = Date.now() - Number(lastUpdate);

      console.log('Tiempo transcurrido desde última actualización:', diff, 'ms');









      // Si se pasó de 24 horas pero aún no se cumplen 48

      if (diff > 86400000 && diff < 172800000) {

        // Si no se ha disparado ya para 24 horas (o se podría usar una bandera distinta)

        if (!localStorage.getItem('cart_abandoned_24')) {

          console.log('Evento cart_abandoned de 24hs disparado globalmente (solo mail)');

          localStorage.setItem('cart_abandoned_24', 'true');



          $.ajax({

            url: window.eventosStoreUrl,

            type: 'POST',

            data: {

              cliente_id: window.clienteId,

              tipo_evento: 'cart_abandonated',

              lapso: 24, // Indica que se trata del evento de 24 horas

              enviar_mail: true,

              fecha: new Date().toISOString()

            },

            headers: {

              'X-CSRF-TOKEN': window.csrfToken

            },

            success: function (response) {

              console.log(response.mensaje);

            },

            error: function (xhr, status, error) {

              console.error('Error al procesar el evento', error);

            }

          });

        }

      }

      // Si se pasó de 48 horas:

      else if (diff >= 172800000) {

        if (!localStorage.getItem('cart_abandoned_48')) {

          console.log('Evento cart_abandoned de 48hs disparado globalmente (mail + guardar datos)');

          localStorage.setItem('cart_abandoned_48', 'true');



          $.ajax({

            url: window.eventosStoreUrl,

            type: 'POST',

            data: {

              cliente_id: window.clienteId,

              tipo_evento: 'cart_abandonated',

              lapso: 48, // Indica que se trata del evento de 48 horas

              enviar_mail: true,

              fecha: new Date().toISOString()

            },

            headers: {

              'X-CSRF-TOKEN': window.csrfToken

            },

            success: function (response) {

              console.log(response.mensaje);

            },

            error: function (xhr, status, error) {

              console.error('Error al procesar el evento', error);

            }

          });

        }

      } else {

        console.log('El umbral no se ha superado.');

      }

    } else {

      console.log('No hay timestamp guardado en cart_last_update.');

    }

  },

  addToCart: function (product) {

    console.log('addToCart se llamó con:', product);

    window.dataLayer = window.dataLayer || [];

    dataLayer.push({

      event: 'add_to_cart',

      debug_mode: true,

      item_name: product.item_name,

      ecommerce: {

        currency: 'ARS',

        value: product.price,

        items: [product]

      }

    });

    // Actualiza la hora de la última acción en el carrito

    this.setCartTimestamp();

  },



  completePurchase: function (orderData) {

    // Envía el evento de compra

    window.dataLayer = window.dataLayer || [];

    dataLayer.push({

      event: 'purchase',

      debug_mode: true,

      ecommerce: orderData

    });

    // Al finalizar la compra, limpiamos la marca de tiempo y la bandera de abandono

    localStorage.removeItem('cart_last_update');

    localStorage.removeItem('cart_abandoned');

  }

};


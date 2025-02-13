// Capturamos el parámetro 'prod' de la URL
const prod = new URLSearchParams(window.location.search).get('prod');

// Ajusta la ruta de tu backend si es necesario
//const ruta_back = "https://tuservidor.com/api";

fetch(ruta_back + "?producto=" + prod)
  .then(function(response) {
    return response.json();
  })
  .then(function(datos) {
    let contenedor = document.querySelector("main");

    // Título principal con el logo del producto
    let tituloPrincipal = document.createElement("h1");
    let color = prod.replace("jocarsa | ","")
    tituloPrincipal.innerHTML = `<img src='static/logo/${color}.png' class='logo'> ${prod}`;
    contenedor.appendChild(tituloPrincipal);

    // Recorremos los bloques del JSON
    datos.forEach(function(dato) {
      // Creamos un div para la sección
      let seccion = document.createElement("div");
      seccion.classList.add(dato.tipo); // e.g. "completo", "bloque", etc.
      seccion.classList.add("bloque");

      // Aplicamos color de fondo si existe
      if (dato.contenido.fondo) {
        seccion.style.background = dato.contenido.fondo;
      }

      // Título, subtítulo y texto (comunes)
      let h3 = document.createElement("h3");
      h3.textContent = dato.contenido.titulo || "";
      seccion.appendChild(h3);

      let h4 = document.createElement("h4");
      h4.textContent = dato.contenido.subtitulo || "";
      seccion.appendChild(h4);

      let p = document.createElement("p");
      p.textContent = dato.contenido.texto || "";
      seccion.appendChild(p);

      // Si existe 'imagen' (nivel de bloque), la mostramos
      if (dato.contenido.imagen) {
        let imgBloque = document.createElement("img");
        imgBloque.src = dato.contenido.imagen;
        imgBloque.alt = dato.contenido.titulo || "Imagen";
        imgBloque.classList.add("imagen-bloque");
        seccion.appendChild(imgBloque);
      }

      // Lógica adicional según el "tipo" de bloque
      switch (dato.tipo) {

        case "completo":
          // Bloque a ancho completo (ya cubrimos fondo e imagen arriba)
          break;

        case "doscolumnas":
          // Render de columnas
          if (dato.contenido.columnas) {
            let columnas = document.createElement("section");
            dato.contenido.columnas.forEach(function(columna) {
              let articulo = document.createElement("article");

              let titulocolumna = document.createElement("h5");
              titulocolumna.textContent = columna.titulo || "";
              articulo.appendChild(titulocolumna);

              let subtitulocolumna = document.createElement("h6");
              subtitulocolumna.textContent = columna.subtitulo || "";
              articulo.appendChild(subtitulocolumna);

              let textoCol = document.createElement("p");
              textoCol.textContent = columna.texto || "";
              articulo.appendChild(textoCol);

              columnas.appendChild(articulo);
            });
            seccion.appendChild(columnas);
          }
          break;

        case "youtube":
          // Mostramos un iframe de YouTube
          if (dato.contenido.url) {
            let iframe = document.createElement("iframe");
            // Si la URL es estilo "https://www.youtube.com/watch?v=VIDEO_ID",
            // convertimos a "embed/VIDEO_ID"
            let embedUrl = dato.contenido.url.replace("watch?v=", "embed/");
            iframe.setAttribute("src", embedUrl);
            iframe.setAttribute("frameborder", "0");
            iframe.setAttribute("allowfullscreen", "true");
            seccion.appendChild(iframe);
          }
          break;

        case "bloque":
          // Bloque simple (ya se añadieron título, subtítulo, texto e imagen)
          break;

        case "mosaico":
          // Pequeñas cards en forma de rejilla
          if (dato.contenido.bloques) {
            let rejilla = document.createElement("section");
            dato.contenido.bloques.forEach(function(b) {
              let articulo = document.createElement("article");

              let ht = document.createElement("h5");
              ht.textContent = b.titulo || "";
              articulo.appendChild(ht);

              let hs = document.createElement("h6");
              hs.textContent = b.subtitulo || "";
              articulo.appendChild(hs);

              let txt = document.createElement("p");
              txt.textContent = b.texto || "";
              articulo.appendChild(txt);

              rejilla.appendChild(articulo);
            });
            seccion.appendChild(rejilla);
          }
          break;

        case "testimonios":
          // Listado de testimonios
          if (dato.contenido.testimonios) {
            let contTestimonios = document.createElement("div");
            contTestimonios.classList.add("testimonios-container");

            dato.contenido.testimonios.forEach(function(t) {
              let testDiv = document.createElement("blockquote");

              let nombre = document.createElement("strong");
              nombre.textContent = t.nombre || "";
              testDiv.appendChild(nombre);

              let cargo = document.createElement("em");
              cargo.textContent = ` (${t.cargo || ""})`;
              testDiv.appendChild(cargo);

              let comentario = document.createElement("p");
              comentario.textContent = t.comentario || "";
              testDiv.appendChild(comentario);

              if (t.imagen) {
                let img = document.createElement("img");
                img.src = t.imagen;
                img.alt = t.nombre || "Testimonio";
                testDiv.appendChild(img);
              }

              contTestimonios.appendChild(testDiv);
            });
            seccion.appendChild(contTestimonios);
          }
          break;

        case "faq":
          // Preguntas frecuentes
          if (dato.contenido.preguntas) {
            let listaFaq = document.createElement("dl");
            dato.contenido.preguntas.forEach(function(faq) {
              let dt = document.createElement("dt");
              dt.textContent = faq.pregunta || "";

              let dd = document.createElement("dd");
              dd.textContent = faq.respuesta || "";

              listaFaq.appendChild(dt);
              listaFaq.appendChild(dd);
            });
            seccion.appendChild(listaFaq);
          }
          break;

        case "cta":
          // Botón "Call To Action"
          if (dato.contenido.boton) {
            let boton = document.createElement("a");
            boton.textContent = dato.contenido.boton.texto_boton || "Ver más";
            boton.href = dato.contenido.boton.url || "#";
            boton.classList.add("boton-cta");
            seccion.appendChild(boton);
          }
          break;

        case "contacto":
          // Formulario de contacto
          if (dato.contenido.formulario) {
            let form = document.createElement("form");
            form.action = dato.contenido.formulario.url_envio || "#";
            form.method = "POST";

            dato.contenido.formulario.campos.forEach(function(c) {
              let label = document.createElement("label");
              label.textContent = c.nombre_campo;

              let input;
              if (c.tipo === "textarea") {
                input = document.createElement("textarea");
              } else {
                input = document.createElement("input");
                input.type = c.tipo || "text";
              }
              input.required = c.requerido || false;

              form.appendChild(label);
              form.appendChild(input);
            });

            let btn = document.createElement("button");
            btn.textContent = dato.contenido.formulario.texto_boton || "Enviar";
            form.appendChild(btn);

            seccion.appendChild(form);
          }
          break;

        case "precios":
          // Distintos planes y precios
          if (dato.contenido.planes) {
            let planesContainer = document.createElement("div");
            planesContainer.classList.add("planes-container");

            dato.contenido.planes.forEach(function(plan) {
              let divPlan = document.createElement("div");
              divPlan.classList.add("plan");

              let h5 = document.createElement("h5");
              h5.textContent = plan.nombre || "";
              divPlan.appendChild(h5);

              let precio = document.createElement("p");
              precio.textContent = `${plan.precio || ""} / ${plan.periodo || ""}`;
              divPlan.appendChild(precio);

              let ul = document.createElement("ul");
              (plan.caracteristicas || []).forEach(function(car) {
                let li = document.createElement("li");
                li.textContent = car;
                ul.appendChild(li);
              });
              divPlan.appendChild(ul);

              if (plan.boton) {
                let btnPlan = document.createElement("a");
                btnPlan.textContent = plan.boton.texto_boton || "Comprar";
                btnPlan.href = plan.boton.url || "#";
                btnPlan.classList.add("boton-cta");
                divPlan.appendChild(btnPlan);
              }

              planesContainer.appendChild(divPlan);
            });
            seccion.appendChild(planesContainer);
          }
          break;

        case "carrusel":
          // Carrusel de slides (básico)
          if (dato.contenido.slides) {
            let wrapper = document.createElement("div");
            wrapper.classList.add("carrusel-wrapper");

            dato.contenido.slides.forEach(function(slide) {
              let slideDiv = document.createElement("article");
              slideDiv.classList.add("slide");

              let h5 = document.createElement("h5");
              h5.textContent = slide.titulo || "";
              slideDiv.appendChild(h5);

              let desc = document.createElement("p");
              desc.textContent = slide.descripcion || "";
              slideDiv.appendChild(desc);

              if (slide.imagen) {
                let img = document.createElement("img");
                img.src = slide.imagen;
                img.alt = slide.titulo || "Slide";
                slideDiv.appendChild(img);
              }
              if (slide.enlace) {
                let link = document.createElement("a");
                link.href = slide.enlace;
                link.textContent = "Más info";
                slideDiv.appendChild(link);
              }

              wrapper.appendChild(slideDiv);
            });
            seccion.appendChild(wrapper);
          }
          break;

        case "equipo":
          // Presentación del equipo
          if (dato.contenido.miembros) {
            let contEquipo = document.createElement("div");
            contEquipo.classList.add("equipo-container");

            dato.contenido.miembros.forEach(function(m) {
              let art = document.createElement("article");

              let h5 = document.createElement("h5");
              h5.textContent = m.nombre || "";
              art.appendChild(h5);

              let cargo = document.createElement("h6");
              cargo.textContent = m.cargo || "";
              art.appendChild(cargo);

              if (m.imagen) {
                let img = document.createElement("img");
                img.src = m.imagen;
                img.alt = m.nombre || "Miembro del equipo";
                art.appendChild(img);
              }

              let desc = document.createElement("p");
              desc.textContent = m.descripcion || "";
              art.appendChild(desc);

              contEquipo.appendChild(art);
            });
            seccion.appendChild(contEquipo);
          }
          break;

        case "newsletter":
          // Form para suscribirse
          if (dato.contenido.formulario) {
            let formNews = document.createElement("form");
            formNews.action = dato.contenido.formulario.url_envio || "#";
            formNews.method = "POST";

            dato.contenido.formulario.campos.forEach(function(campo) {
              let label = document.createElement("label");
              label.textContent = campo.nombre_campo;

              let input = document.createElement("input");
              input.type = campo.tipo || "text";
              input.required = campo.requerido || false;

              formNews.appendChild(label);
              formNews.appendChild(input);
            });

            let btnNews = document.createElement("button");
            btnNews.textContent = dato.contenido.formulario.texto_boton || "Suscribirme";
            formNews.appendChild(btnNews);

            seccion.appendChild(formNews);
          }
          break;

        case "galeria":
          // Galería de imágenes
          if (dato.contenido.imagenes) {
            let galeria = document.createElement("div");
            galeria.classList.add("galeria-container");

            dato.contenido.imagenes.forEach(function(imgObj) {
              let img = document.createElement("img");
              img.src = imgObj.src || "";
              img.alt = imgObj.alt || "Imagen";
              galeria.appendChild(img);
            });
            seccion.appendChild(galeria);
          }
          break;

        case "logos":
          // Presentar logos de socios/aliados
          if (dato.contenido.items) {
            let contLogos = document.createElement("div");
            contLogos.classList.add("logos-container");

            dato.contenido.items.forEach(function(item) {
              let link = document.createElement("a");
              link.href = item.link || "#";

              let imgLogo = document.createElement("img");
              imgLogo.src = item.logo || "";
              imgLogo.alt = item.nombre || "Logo";
              link.appendChild(imgLogo);

              contLogos.appendChild(link);
            });
            seccion.appendChild(contLogos);
          }
          break;

        case "mapa":
          // Insertar iframe/HTML de Google Maps
          if (dato.contenido.embed_mapa) {
            let mapaDiv = document.createElement("div");
            mapaDiv.classList.add("mapa-container");
            mapaDiv.innerHTML = dato.contenido.embed_mapa;
            seccion.appendChild(mapaDiv);
          }
          break;

        case "countdown":
          // Muestra la fecha objetivo
          if (dato.contenido.fecha_objetivo) {
            let fechaP = document.createElement("p");
            fechaP.textContent = "Finaliza el: " + dato.contenido.fecha_objetivo;
            seccion.appendChild(fechaP);
          }
          if (dato.contenido.boton) {
            let botonC = document.createElement("a");
            botonC.textContent = dato.contenido.boton.texto_boton || "Reservar";
            botonC.href = dato.contenido.boton.url || "#";
            botonC.classList.add("boton-cta");
            seccion.appendChild(botonC);
          }
          break;

        case "blog":
          // Últimas entradas
          if (dato.contenido.entradas) {
            let blogContainer = document.createElement("div");
            blogContainer.classList.add("blog-container");

            dato.contenido.entradas.forEach(function(entry) {
              let art = document.createElement("article");

              let tEntry = document.createElement("h5");
              tEntry.textContent = entry.titulo || "";
              art.appendChild(tEntry);

              let meta = document.createElement("small");
              meta.textContent = `${entry.autor || ""} - ${entry.fecha || ""}`;
              art.appendChild(meta);

              let resumen = document.createElement("p");
              resumen.textContent = entry.resumen || "";
              art.appendChild(resumen);

              if (entry.imagen) {
                let img = document.createElement("img");
                img.src = entry.imagen;
                img.alt = entry.titulo || "Blog imagen";
                art.appendChild(img);
              }

              let link = document.createElement("a");
              link.textContent = "Leer más";
              link.href = entry.url || "#";
              art.appendChild(link);

              blogContainer.appendChild(art);
            });
            seccion.appendChild(blogContainer);
          }
          break;

        case "cronologia":
          // Línea de tiempo / hitos
          if (dato.contenido.hitos) {
            let contCrono = document.createElement("div");
            contCrono.classList.add("cronologia-container");

            dato.contenido.hitos.forEach(function(h) {
              let hitoDiv = document.createElement("div");
              hitoDiv.classList.add("hito");

              let fecha = document.createElement("strong");
              fecha.textContent = h.fecha || "";
              hitoDiv.appendChild(fecha);

              let h5 = document.createElement("h5");
              h5.textContent = h.titulo || "";
              hitoDiv.appendChild(h5);

              let desc = document.createElement("p");
              desc.textContent = h.descripcion || "";
              hitoDiv.appendChild(desc);

              contCrono.appendChild(hitoDiv);
            });
            seccion.appendChild(contCrono);
          }
          break;

        case "pasos":
          // Mostrar proceso en pasos
          if (dato.contenido.pasos) {
            let olPasos = document.createElement("ol");
            olPasos.classList.add("pasos-container");

            dato.contenido.pasos.forEach(function(paso) {
              let li = document.createElement("li");
              let strongTitulo = document.createElement("strong");
              strongTitulo.textContent = `${paso.numero}. ${paso.titulo} `;
              li.appendChild(strongTitulo);

              let desc = document.createElement("p");
              desc.textContent = paso.descripcion || "";
              li.appendChild(desc);

              olPasos.appendChild(li);
            });
            seccion.appendChild(olPasos);
          }
          break;

        case "premios":
          // Listado de premios/reconocimientos
          if (dato.contenido.lista_premios) {
            let ulPremios = document.createElement("ul");
            ulPremios.classList.add("premios-container");

            dato.contenido.lista_premios.forEach(function(premio) {
              let li = document.createElement("li");

              let nombre = document.createElement("strong");
              nombre.textContent = premio.nombre || "";
              li.appendChild(nombre);

              let otorgado = document.createElement("em");
              otorgado.textContent = ` - Otorgado por: ${premio.otorgado_por || ""}`;
              li.appendChild(otorgado);

              let fecha = document.createElement("span");
              fecha.textContent = ` (${premio.fecha || ""}) `;
              li.appendChild(fecha);

              let desc = document.createElement("p");
              desc.textContent = premio.descripcion || "";
              li.appendChild(desc);

              ulPremios.appendChild(li);
            });
            seccion.appendChild(ulPremios);
          }
          break;

        case "politica":
          // Enlaces a políticas
          if (dato.contenido.enlaces_politica) {
            let ulPoliticas = document.createElement("ul");
            dato.contenido.enlaces_politica.forEach(function(pol) {
              let li = document.createElement("li");
              let a = document.createElement("a");
              a.textContent = pol.titulo || "Política";
              a.href = pol.url || "#";
              li.appendChild(a);
              ulPoliticas.appendChild(li);
            });
            seccion.appendChild(ulPoliticas);
          }
          break;

        default:
          console.warn("Tipo de bloque no reconocido:", dato.tipo);
          break;
      }

      // Insertamos la sección en el contenedor principal
      contenedor.appendChild(seccion);
    });
  })
  .catch(function(err) {
    console.error("Error al cargar los datos:", err);
  });


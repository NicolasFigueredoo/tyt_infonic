response = ws.AddCustomer(<Request>
            <Authentication
                ApplicationId="16C9326D-D680-493E-A327-69821CC8451C"
                AuthenticationId=<%= SessionId %>/>

            <!-- TaxCondition puede tener estos valores: ResponsableInscripto, ResponsableNoInscripto, Exento, NoResponsable, ConsumidorFinal, ResponsableNoInscriptoVentaDeBienesDeUso, ResponsableMonotributo, MonotributistaSocial, ForeignCustomer -->
            <Customer TaxCondition="ResponsableInscripto" BusinessName="Nombre Comercial">

                <!-- Según corresponda enviar el nodo Person o Company -->
                <!-- El tipo de documento es CUIT, CUIL, LE, LC, DNI, Pasaporte, CI, SinDocumento, InscripcionIIBB -->
                <!--<Person FirstName="TestNombre2" LastName="TestApellido2" DocumentType="CUIT" DocumentNumber="20-24773745-7">
                </Person>-->

                <!-- Según corresponda enviar el nodo Person o Company -->

                <Company Name="TestNombreCompany" CUIT="20-24773745-7">
                </Company>

                <CustomerAddress Street="Franco" StreetNumber="3340" City="CABA" State="Bs. As." PostalCode="1234" Body="" Floor="2" Department="231" Office=""/>

                <DeliveryAddress Street="Vergara" StreetNumber="4183" City="Vicente Lopez" State="Bs. As." PostalCode="1425" Body="" Floor="" Department="" Office=""/>

                <ContactInfo Telephone="15-3020-3446" EMail="eyanson@bizcom.com.ar"/>

                <Comments>
                    <![CDATA[Comentarios de prueba.]]>
                </Comments>
            </Customer>

        </Request>.ToString)
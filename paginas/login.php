<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    <?php
    include("headers/headerBootstrap.php");
    ?>


    <link rel="stylesheet" href="css/login.css">

</head>

<body>

    <div class="wrapper">
        <div class="logo">
            <img src="https://w7.pngwing.com/pngs/770/246/png-transparent-judge-lawyer-gavel-training-course-hand-logo-law-firm.png"
                alt="">
        </div>
        <div class="text-center mt-4 name">
            Iniciar Sesion
        </div>
        <form class="p-3 mt-3" onsubmit="event.preventDefault(); iniciarSesion();">
            <div class="form-field d-flex align-items-center">
                <span class="far fa-user"></span>
                <input type="text" name="inputUsuario" id="inputUsuario" placeholder="Usuario" value="">
            </div>
            <div class="form-field d-flex align-items-center">
                <span class="fas fa-key"></span>
                <input type="password" name="inputContrasenia" id="inputContrasenia" placeholder="Contraseña"
                    value="">
            </div>
            <button class="btn mt-3">Acceder</button>
        </form>
        <!-- <div class="text-center fs-6">
            <a href="#">Forget password?</a> or <a href="#">Sign up</a>
        </div> -->
    </div>

    <script>

        // Your web app's Firebase configuration
        const firebaseConfig = {
            apiKey: "AIzaSyCXwPn2E2rUXh1oT2AeJpVTAV7pMw1NNcY",
            authDomain: "wifinet-df089.firebaseapp.com",
            databaseURL: "https://wifinet-df089.firebaseio.com",
            projectId: "wifinet-df089",
            storageBucket: "wifinet-df089.appspot.com",
            messagingSenderId: "964535514142",
            appId: "1:964535514142:web:5a3c567bcfe000cfadaa0f"
        };

        // Initialize Firebase
        const app = firebase.initializeApp(firebaseConfig);

        //    const uid = window.localStorage.getItem('uid');
        //    console.log(uid);


        // const usuario = document.getElementById("inputUsuario");
        // const contrasenia = document.getElementById("inputContrasenia");

        function iniciarSesion() {
            const usuario = document.getElementById("inputUsuario").value;
            const contrasenia = document.getElementById("inputContrasenia").value;
            console.log(usuario, contrasenia);

            Swal.fire({
                title: 'Iniciando sesion',
                timerProgressBar: true,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                },
            });

            const userFireStore = app.firestore().collection('usuarios').doc(usuario);
            userFireStore.get().then((doc) => {
                if (doc.exists) {
                    console.log('exists');
                    console.log(doc.data());

                    $.ajax({
                        type: "POST",
                        url: 'funcionesphp/validatehash.php',
                        data: {
                            pass: contrasenia,
                            hash: doc.data().contrasenia
                        },
                        success: function (response) {
                            console.log(response);
                            if (response === 'valid') {
                                console.log('sesion iniciada');

                                setTimeout(() => {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Sesión iniciada',
                                        showConfirmButton: false
                                    });

                                    setTimeout(() => {
                                        window.location.href = "/proyectoFinal/paginas/menu.php";
                                    }, 2000);
                                    
                                }, 1200);

                            } else {
                                console.log('error al iniciar sesion');
                                setTimeout(() => {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'revise sus credenciales',
                                        showConfirmButton: false,
                                        showCloseButton: true,
                                    });
                                }, 1200);
                            }
                        },
                        error: function (xhr, status) {
                            setTimeout(() => {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'No se pudo iniciar sesión',
                                        showConfirmButton: false
                                    });
                                }, 1200);
                        }
                    });


                } else {
                    console.log('not exists');
                    setTimeout(() => {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'revise sus credenciales',
                                        showConfirmButton: false,
                                        showCloseButton: true,
                                    });
                                }, 1200);
                }
            }).catch((error) => {
                console.log("Error getting document:", error);
            });

        }

        function pruebaTest() {
            // console.log(usuario.value);
            // console.log(contrasenia.value);
            // writeUserData('cmQ2HpAWgUm7a8ZGdOQq', false);

            // $.ajax({
            //     type: "POST",
            //     url: '../php/validatehash.php',
            //     data: {
            //         pass: contrasenia.value,
            //     },
            //     success: function (response) {
            //         console.log(response);
            //     }
            // });

            // $.ajax({
            //     type: "POST",
            //     url: '../php/hashpassword.php',
            //     data: {
            //         pass: contrasenia.value,
            //     },
            //     success: function (response) {
            //         console.log(response);
            //     }
            // });


            // app.auth().signOut().then(() => {
            //     // Sign-out successful.
            //     console.log('se cerro sesion');
            // }).catch((error) => {
            //     // An error happened.
            //     console.log(error);
            // });

            // app.auth().signInWithEmailAndPassword(usuario.value, contrasenia.value)
            //     .then((userCredential) => {
            //         // Signed in
            //         var user = userCredential.user;
            //         console.log(user);
            //         console.log(user.uid);
            //         window.localStorage.setItem('uid', user.uid);
            //         // ...
            //     })
            //     .catch((error) => {
            //         var errorCode = error.code;
            //         var errorMessage = error.message;
            //         console.log(errorMessage);
            //     });



            // app.auth().createUserWithEmailAndPassword(usuario.value, contrasenia.value)
            //     .then((userCredential) => {
            //         // Signed in
            //         var user = userCredential.user;
            //         console.log(user);
            //         // ...
            //     })
            //     .catch((error) => {
            //         var errorCode = error.code;
            //         var errorMessage = error.message;
            //         console.log(errorMessage);
            //         // ..
            //     });

        }

        async function writeUserData(userId, activo) {

            // const user = app.firestore().collection('usuarios').doc('cmQ2HpAWgUm7a8ZGdOQq');
            // user.get().then((doc) => {
            //     if (doc.exists) {
            //         console.log("Document data:", doc.data());
            //     } else {
            //         // doc.data() will be undefined in this case
            //         console.log("No such document!");
            //     }
            // }).catch((error) => {
            //     console.log("Error getting document:", error);
            // });


            // app.firestore().collection("usuarios").where("activo", "==", true)
            //     .get()
            //     .then((querySnapshot) => {
            //         querySnapshot.forEach((doc) => {
            //             // doc.data() is never undefined for query doc snapshots
            //             console.log(doc.id, " => ", doc.data());
            //         });
            //     })
            //     .catch((error) => {
            //         console.log("Error getting documents: ", error);
            //     });

            // app.firestore().collection('usuarios').doc('cmQ2HpAWgUm7a8ZGdOQq').get()
            //     .then(snapshot => {console.log(snapshot.id, '=>', snapshot.data());})

            // const snapshot = await app.firestore().collection('usuarios').get()
            // var usuarios = snapshot.docs.map(doc => doc.data());
            // console.log(usuarios);

            // var usuario = await app.firestore().collection('usuarios').doc('cmQ2HpAWgUm7a8ZGdOQq').get();
            // console.log(usuario);

            // const liam = await
            //     app.firestore().collection('usuarios').doc('cmQ2HpAWgUm7a8ZGdOQq').set({
            //         // usuario: 'mike',
            //         // contrasenia: '12345',
            //         activo: true
            //     }, { merge: true });

            // const liam = await
            //     app.firestore().collection('usuarios').doc('cmQ2HpAWgUm7a8ZGdOQq').update({
            //         // usuario: 'mike',
            //         // contrasenia: '12345',
            //         activo: true
            //     });

            // console.log(liam);

        }

    </script>

</body>

</html>
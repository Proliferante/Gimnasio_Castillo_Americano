<?php include "header.php"; ?>

<style>
:root {
    --gca-gold: #c9a24d;
    --gca-dark: #0f0f0f;
    --gca-gray: #f5f6f8;
}

/* HERO */
.hero-nosotros {
    background:
        linear-gradient(rgba(15,15,15,.7), rgba(15,15,15,.7)),
        url("assets/img/img5.png");
    background-size: cover;
    background-position: center;
    padding: 140px 20px;
    color: #fff;
}

/* TITULOS */
.section-title {
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.gold-line {
    width: 90px;
    height: 4px;
    background: var(--gca-gold);
    margin: 20px auto 35px;
    border-radius: 10px;
}

/* BLOQUE HISTORIA */
.history-box {
    background: #fff;
    border-radius: 24px;
    padding: 50px;
    box-shadow: 0 18px 45px rgba(0,0,0,.08);
    margin-bottom: 80px;
}

.history-box p {
    font-size: 17px;
    line-height: 1.9;
    color: #444;
}

/* CARDS */
.institution-card {
    border: none;
    border-radius: 22px;
    padding: 45px 30px;
    height: 100%;
    background: #fff;
    box-shadow: 0 15px 40px rgba(0,0,0,.1);
    transition: all .35s ease;
    position: relative;
}

.institution-card::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 6px;
    background: var(--gca-gold);
    border-radius: 22px 22px 0 0;
}

.institution-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 60px rgba(0,0,0,.15);
}

.institution-card h4 {
    font-weight: 800;
    margin-bottom: 20px;
}

.institution-card p {
    font-size: 16px;
    color: #555;
    line-height: 1.7;
}

/* BLOQUE COMPROMISO */
.commitment {
    background: linear-gradient(rgba(15,15,15,.9), rgba(15,15,15,.9)),
                url("assets/img/colegio.png");
    background-size: cover;
    background-position: center;
    border-radius: 30px;
    padding: 80px 40px;
    color: #fff;
    margin-top: 90px;
}

.commitment p {
    max-width: 850px;
    margin: 25px auto;
    font-size: 18px;
    color: #ddd;
}

/* BOTÓN */
.btn-gca {
    background: var(--gca-gold);
    color: #000;
    border-radius: 40px;
    padding: 12px 40px;
    font-weight: 700;
    border: none;
}

.btn-gca:hover {
    background: #b8933f;
    color: #000;
}
</style>

<!-- HERO -->
<section class="hero-nosotros text-center">
    <div class="container">
        <h1 class="display-5 fw-bold">Quiénes Somos</h1>
        <p class="lead mt-3">
            Formación con carácter, valores sólidos y excelencia académica
        </p>
    </div>
</section>

<div class="container my-5">

    <!-- HISTORIA -->
    <div class="text-center mb-5">
        <h2 class="section-title">Nuestra Historia</h2>
        <div class="gold-line"></div>
    </div>

    <div class="history-box text-center">
        <p>
            El <strong>Gimnasio Castillo Americano</strong> surge con la visión de brindar
            una educación integral basada en la disciplina, los valores y el compromiso
            social, formando estudiantes capaces de enfrentar los desafíos académicos
            y personales del mundo actual.
        </p>

        <p>
            A lo largo de los años, la institución ha consolidado un modelo educativo
            que integra la formación académica con el desarrollo humano, fortaleciendo
            el liderazgo, la responsabilidad y el respeto como pilares fundamentales.
        </p>
    </div>

    <!-- MISIÓN / VISIÓN / VALORES -->
    <div class="row g-4 text-center">

        <div class="col-md-4">
            <div class="institution-card">
                <h4>Misión</h4>
                <p>
                    Formar estudiantes íntegros, con excelencia académica,
                    principios éticos sólidos y sentido de responsabilidad
                    social.
                </p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="institution-card">
                <h4>Visión</h4>
                <p>
                    Ser una institución educativa reconocida por su calidad,
                    innovación pedagógica y compromiso con la formación
                    integral del estudiante.
                </p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="institution-card">
                <h4>Valores</h4>
                <p>
                    Respeto, disciplina, honestidad, responsabilidad,
                    compromiso y trabajo en equipo como fundamentos
                    de nuestra comunidad educativa.
                </p>
            </div>
        </div>

    </div>

    <!-- COMPROMISO -->
    <div class="commitment text-center">
        <h2 class="fw-bold">Nuestro Compromiso</h2>
        <p>
            Contamos con un equipo docente y administrativo altamente comprometido
            con la innovación pedagógica, el acompañamiento permanente y la formación
            de ciudadanos responsables y preparados para el futuro.
        </p>

        <a href="index.php" class="btn btn-gca mt-4">
            Volver al inicio
        </a>
    </div>

</div>

<?php include "footer.php"; ?>

-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-11-2020 a las 19:46:18
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bar70`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `IdCliente` int(11) NOT NULL,
  `IdTipoDocumento` int(11) NOT NULL,
  `Numero_Documento` varchar(20) NOT NULL,
  `Nombre` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`IdCliente`, `IdTipoDocumento`, `Numero_Documento`, `Nombre`) VALUES
(1, 1, '1000853202', 'Nicolas '),
(2, 2, '12345uio', 'Alvaro'),
(3, 2, '5690\'09876', 'Laura'),
(4, 1, '23456789', 'szs'),
(5, 1, '545', 'nbnb');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `IdCompra` int(11) NOT NULL,
  `IdProveedor` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `observaciones` varchar(255) NOT NULL,
  `hora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`IdCompra`, `IdProveedor`, `fecha`, `observaciones`, `hora`) VALUES
(74, 1, '2020-11-09', 'jajaja ya', '19:57:16'),
(75, 2, '2020-11-09', 'yaaa', '19:59:09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compra`
--

CREATE TABLE `detalle_compra` (
  `IdDetalleCompra` int(11) NOT NULL,
  `IdProducto` int(11) NOT NULL,
  `IdCompra` int(11) NOT NULL,
  `cantidad` double NOT NULL,
  `iva` double NOT NULL,
  `total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `detalle_compra`
--

INSERT INTO `detalle_compra` (`IdDetalleCompra`, `IdProducto`, `IdCompra`, `cantidad`, `iva`, `total`) VALUES
(51, 5, 75, 4, 0, 12800);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta`
--

CREATE TABLE `detalle_venta` (
  `IdDetalleVenta` int(11) NOT NULL,
  `IdUnidadMedida` int(11) NOT NULL,
  `IdVenta` int(11) NOT NULL,
  `IdProducto` int(11) NOT NULL,
  `Unidad_Medida` double NOT NULL,
  `cantidad` double NOT NULL,
  `iva` double NOT NULL,
  `total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `detalle_venta`
--

INSERT INTO `detalle_venta` (`IdDetalleVenta`, `IdUnidadMedida`, `IdVenta`, `IdProducto`, `Unidad_Medida`, `cantidad`, `iva`, `total`) VALUES
(1, 1, 1, 1, 1, 5, 0, 20500),
(2, 1, 2, 1, 1, 5, 0, 20500);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `IdEstado` int(11) NOT NULL,
  `Nombre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_venta`
--

CREATE TABLE `estado_venta` (
  `IdEstadoVenta` int(11) NOT NULL,
  `Pendiente` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `estado_venta`
--

INSERT INTO `estado_venta` (`IdEstadoVenta`, `Pendiente`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `home`
--

CREATE TABLE `home` (
  `IdHome` int(11) NOT NULL,
  `Mision` varchar(256) NOT NULL,
  `Vision` varchar(256) NOT NULL,
  `Quienes_Somos` varchar(256) NOT NULL,
  `ImagenMision` varchar(512) NOT NULL,
  `ImagenVision` varchar(512) NOT NULL,
  `ImagenPrincipal` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `home`
--

INSERT INTO `home` (`IdHome`, `Mision`, `Vision`, `Quienes_Somos`, `ImagenMision`, `ImagenVision`, `ImagenPrincipal`) VALUES
(1, 'vender a toda costa', 'ser reconocidos mundialmente', 'Somos una empresa responsable ', 'Configuracion/img/1605292006_598cfa8c9370e.jpeg', 'Configuracion/img/1605292014_53119247_m-e1574455936994.jpg', 'Configuracion/img/1604530759_Bar.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marca`
--

CREATE TABLE `marca` (
  `IdMarca` int(12) NOT NULL,
  `Nombre` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `marca`
--

INSERT INTO `marca` (`IdMarca`, `Nombre`) VALUES
(1, 'postobon'),
(2, 'aguardiente'),
(3, 'ron 8 años');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulos_asignados`
--

CREATE TABLE `modulos_asignados` (
  `id` int(12) NOT NULL,
  `nombre_modulo` varchar(255) NOT NULL,
  `user_id` int(12) NOT NULL,
  `user_id_asignador` int(12) NOT NULL,
  `date_added` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `novedad`
--

CREATE TABLE `novedad` (
  `IdNovedad` int(11) NOT NULL,
  `IdProducto` int(4) NOT NULL,
  `IdTipoNovedad` int(11) NOT NULL,
  `Cantidad` int(4) NOT NULL,
  `Descripcion` text NOT NULL,
  `Fecha` date NOT NULL,
  `Iva` double NOT NULL,
  `Total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `novedad`
--

INSERT INTO `novedad` (`IdNovedad`, `IdProducto`, `IdTipoNovedad`, `Cantidad`, `Descripcion`, `Fecha`, `Iva`, `Total`) VALUES
(1, 1, 1, 20, 'se rompieron en bodega ', '2020-09-18', 0, 0),
(17, 4, 2, 2, 'prueba', '2020-09-27', 2470, 15470),
(18, 2, 2, 2, 'prueba2', '2020-09-27', 1596, 9996),
(20, 4, 1, 10, 'prueba6', '2020-09-27', 12350, 77350),
(21, 3, 1, 10, 'prueba6', '2020-09-27', 8170, 51170),
(22, 2, 1, 10, 'prueba6', '2020-09-27', 7980, 49980),
(23, 1, 1, 10, 'prueba6', '2020-09-27', 7790, 48790),
(24, 2, 1, 2, 'prueba9', '2020-09-27', 1596, 9996),
(25, 1, 1, 5, 'prueba9', '2020-09-27', 3895, 24395),
(26, 4, 1, 2, 'prueba29', '2020-09-27', 2470, 15470),
(27, 4, 1, 2, 'prueba23', '2020-09-27', 2470, 15470),
(28, 4, 1, 2, 'prueba24', '2020-09-27', 2470, 15470),
(29, 4, 1, 2, 'prueba25', '2020-09-27', 2470, 15470),
(30, 4, 1, 2, 'prueba26', '2020-09-27', 2470, 15470),
(31, 4, 2, 20, 'prueba30', '2020-09-28', 24700, 154700),
(32, 4, 2, 20, 'prueba31', '2020-09-28', 24700, 154700),
(33, 1, 1, 5, 'se perdieron dos botellas', '2020-09-28', 0, 20500),
(34, 2, 1, 1, 'se perdieron dos botellas', '2020-09-28', 0, 4200),
(35, 1, 1, 5, '', '2020-09-28', 0, 20500),
(36, 3, 1, 5, '', '2020-09-28', 0, 21500),
(37, 1, 1, 5, 'hghjlkm', '2020-09-28', 0, 20500),
(38, 3, 1, 5, 'hghjlkm', '2020-09-28', 0, 21500),
(39, 2, 1, 5, '', '2020-09-28', 0, 21000),
(40, 3, 1, 1, '', '2020-09-28', 0, 4300),
(41, 1, 1, 5, 'se dañaron todas estas cervezas', '2020-11-03', 0, 20500),
(42, 1, 1, 1, 'se dañaron todas estas cervezas', '2020-11-03', 0, 4100),
(43, 1, 1, 1, 'se dañaron todas estas cervezas', '2020-11-03', 0, 4100);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil`
--

CREATE TABLE `perfil` (
  `id_perfil` int(11) NOT NULL,
  `nombre_empresa` varchar(150) NOT NULL,
  `direccion_territorial` varchar(10) NOT NULL,
  `resolucion_empresa` int(10) NOT NULL,
  `numero_habilitacion` int(11) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `nit_empresa` varchar(100) NOT NULL,
  `representante_legal` varchar(55) CHARACTER SET utf8 DEFAULT NULL,
  `estado` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `email` varchar(64) NOT NULL,
  `email_alerta` varchar(64) NOT NULL,
  `id_telegram` varchar(255) DEFAULT NULL,
  `servidor_verificacion` varchar(255) NOT NULL,
  `impuesto` int(2) NOT NULL,
  `moneda` varchar(255) NOT NULL,
  `logo_url` varchar(255) NOT NULL,
  `firma` varchar(255) DEFAULT NULL,
  `hostEmail` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `userEmail` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `passwordEmail` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `logoGTEP` blob DEFAULT NULL,
  `nombre_banco` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `tipo_cuenta` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `numero_cuenta` varchar(255) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `perfil`
--

INSERT INTO `perfil` (`id_perfil`, `nombre_empresa`, `direccion_territorial`, `resolucion_empresa`, `numero_habilitacion`, `direccion`, `ciudad`, `nit_empresa`, `representante_legal`, `estado`, `telefono`, `email`, `email_alerta`, `id_telegram`, `servidor_verificacion`, `impuesto`, `moneda`, `logo_url`, `firma`, `hostEmail`, `userEmail`, `passwordEmail`, `logoGTEP`, `nombre_banco`, `tipo_cuenta`, `numero_cuenta`) VALUES
(1, 'Bar70', '305', 49, 19, 'CARRERA 65 8 B 91 OF 305', 'Medellín', '901195461-7', 'Juan Zapata', 'Antioquia', '3107237767', 'asistentegerencia@gmail.com', 'asistenteadministrativa@gmail.com', '1014696847', 'https://bar.me', 1, '#1872f2', 'Empresa/img/1601324127_logonegro.png', 'Empresa/img/1595107002_firma.png', 'mail.transportesonix.com', 'info@transportesonix.com', '2h$QNfpd565?', 0x646174613a696d6167652f706e673b6261736536342c6956424f5277304b47676f414141414e5355684555674141415751414141424143415941414141745551323041414141426d4a4c523051412f77442f41502b6776616554414141414358424957584d41414173544141414c457745416d707759414141414233524a5455554834774d4f41786753694a2b5a4a7741414555644a52454655654e72746e587555564d5764787a2f5650544d5851524369726b396356496a4d51384672317332794b327149353851594535587061344b4248675a6632665735726d2b6a5a6c654a72787866776177766d415a467544336a4d316e7771496b4c3852586471784a36414a396f68446943434b677764366237317637526a63476870322f31394f326537706e366e444d48546c6664756c5631662f57746478566f4e42714e52715052614451616a55616a30576730476f31476f39466f4e42714e52715052614451616a55616a30576730476b312b69464b38354c523537614f715174356f454873447734467141436e5a4c6753626b484b6433645477515244766973784c6a4344454163432b5349596a4d41514943643149746f675148536b762f483562302f68742b764e724e4a57425956724467616f796a56375364657a50697962496b5668694448416334506b38482f5a6b65466c62302f6833733462546b6a675677666b437867416a676431336950464f62414f32534d6e48435034374871322f7230394350443978724a447941684154674432414555424e44323964774f66414a676e4c525368306b7a3239396d322f73483830643957496d7244335936425449557333566c56565066504947642f734c7361586a3851535038716b7a34387154345266614a7378666b306552693841492f4f74706742484151634251307456656665434233774976416773426261366a75336d576142507a71526e6f46454e334f4d3639726f73416e5978454b717739486a41375430467a6a43746c34462f4c504f3466777738417977436e676536584d644f35684e415653387150516d5970784a416d46517a384a55676e3772676e534656644a306f55743644434559704244455547436f452b774833526d4b4a36794455324a33736575587857524e7956676a57672b3156736c704d78504e69516c4b6e6f426b31774a37416e674c4734586e4e6b5a624558415258784b503147336f747a47467675345362424372706b5a32705a4e6345344b326776375956613638442b56436d59737364433641724c4862505137424f42483442484170386f30774e2f747764686d2b59317576415261356a712b627a4434457a42326744386b6c6758592f66686d652b5a795879594b62687444506446524476665948706d623855384c3568576b7542793133485675715268334c555571714e62472b6e3174766b61733939566e6a7955595159315a635543646866344c31595856553170334842657a57392b5a73364c7a47614b766d516b4e3672516c4458357936436f466e414371746c35597a652f4b51494a77576f7474794853454b52596e787443616570694847475735383634374176465952346f6d46614476412f77442b5573526a334e507754675457476163554d3039705473655531554a47396d6d376c6b6371526e6b6f69444977467a674f2b4e457a7246734f3039757172494f644e593076376d514b65427634356f4c47556334585875545437384d536167304f434e34485441797667517353732b537650792b6259466830766b66497034457531346947764b3036786b35636f2b74774b7a466351347a4f423134456a4b396a775a77416244644d61694d4d526d6f4844706341477737536d46466551686653736c76594c51304c654477774a4d6755436558776b6c6d6a37577265395a64566b495a5076436258686b447a315474776461556c4573376e5a5451307641456f546a304a51626257302f32764177785558434d4649526538767039696a3355654d5a775033447943442f354e685773666f6371387063353431544f76716f676d79684b7351386f356978563741615932783967734270733566335944776e697a697578434365794f78784b52654250752f3871696f4c686e5a2b6c6b674532476e7866356344664a475666386534745a486f7764364f635234436e446c41445030454c444d4d4b30446333786554666b7a474c375444595a704e57647a71416f67393859587636544a36794c7a33336b493654364e32677144516a41455842465a734770716648727431795953346b313169794b78784c306976594c446a2f31502b474c39642b5070576465434342502b4755696c73574d4a37613352756d647a6950452b774c4d46524b636232464c43676d4f67506d344f45434f395171516e4877442f74314f6854374c72574757795237706b6c742b797a5a6f504a7a332b336874647743756b7878574c6b54393957584c566d666d4f35595a48333866374c774e654b494674686b6e50745977446a67612b6c36654e416a786f6d4e61696e704e39356271757279656a684852586b70374d4b51556e43356b6141325262456e634e634a644347454f45344e52704436353462754773492f6f386f57544e587a6c55536e6c47486a586b4c4238667638777a436b7542527a4a69397062723250307932353270534934456d736739642f41647737536d75493739334d342f756f35394933426a6b654c326265436c4846342b6452313763706d567155577559383863594333506c61356a7639685039726b666341787764715a42494255716875654166367045516161455970787047346c7a67502f5964535343707842636a384a7142416b7a4e753431374b4a4d43366c76704d4a314975516472656a37425946776368684e46614261434663414a376d4f2f56453566487a58735473796c634e5377375275412f3658394a4c4a624679624d6661536c63634b37495a58443843686746412f327564664152757744644d364356674d44504e35624b4a685776746b624c766f4364674176435468486f6e344f636a5a55764930734c5a493733735065455a4b3853754a7545724362544b394f4874394838504c75677775565733384266696a346e444f734a47624f383871714634496554657264765538614c466e314f55532f337355777a6f626d46677559707a462b46386a397961504f734f30776d67302f574f6676774f2b71644b4c7073634b70324b316b47394579766c3255384d75692f616e786c6274485a4b654a51532f447151684378736c6e42644350473948367a7036756b666d7459386d7a506e436b3563696c4c6f524f396a37314956766a33707332726a50647636783759797871556a4c7967564369423871526e41324d4b6376615774636b44684b654878484d522b32657147776e614e3158414e4d565168716d7576596a31534130613832544f7465344a77737a6e746c656a41627444786f2b736b2b3178756d6457796d4a35654c48325236666b566f495574494961625930667072736f6b7851467530646b4f387158364f4a30504846767736795770714f4c4131577238346d786744784766572f53552b6f2b34794c7a33386b46665873627137323877615a6c4e44713153645342474d694c516b7076556c66634a54477176657764325054682b2f4e596637587668505044786343574b384533594f74796c61466759645a645572636831374766432b6a376547596f323564434c6b354c5a6f33653956504c63323153365469446b46764d3852493459644766394a76644b5a426d46526379655335586b4a7676414f7a5347586c2b5552314b7854596f6d386a4355535378776c59494a6950646a4a49596465372b4e74444c75653762457a47336f6270696c6a636d3262506b4c723036436a484d66712f6659756a43714b494576454858613049542f4238304b7a36647332795a5355346e7a3774444764716738736a6f354c53734543386c6c534938586f33707738776e4f52637175536c51692b565a302b49304a4e6a4239614c59515150385a2f556d44484736364e487a50454c3133482b62677663523237307259583536714d52327439307051426674765877385551354b31496556752b4437584f484c3965796a374e68692b4a4e39586c76627a46533457583543504951736f44656e4e72697837574a59575970786a554343453552546d6933616e646b504a7352642b66676c797334472b696a2f7569436a54326a5a6c5766386831624e486a62377257416b305a344c646e595550676769776c6a385362366a2f7430384d683855432b6a33536e6a4a2f31355656747a654d2f6b71416354796e45434238506a77486246596356726c477543454c79457451326e794468325869302f6b4d4672324e38334a64586d7157376a693164782b353248567671637138705577373263582b394343336b304a31396239444c50467649387533486d73663266546d5735452f4b7775697a4f2b3756373431614a68575831516e42384d62353763312b2f7162662b32364e5250776e367048386c614c5059543769396f55754f78704e6342696d4e596e305a48724f336e36676769776c62727970646c56666e342f50724e2b59562f4e4768705956474f555636746f746369344c584c7676666c496762316657546b2f2b334d3950353544746c77766c2b4c45385071502b56645771547863526a615a6b596c79462f37454a4c7241793242617977436c387a454e3938345a45766c6c51644550795066576b39626f5437437673614d4d636d663138673279743550306a7363514a76626c6273542b50456f68475254456d4a4d4a42625833316442485361414c6c55667a3159795051456167674338547141455264655677334a4d546177725266624d73725a6d7265626c414d72305a49706b626d4a304c5a34315a314649724c7459526b53586579362f32416a4565336e6763664137455337766535424d4f306167335457674f63724f44396f7034726d366f437949474f414e4b68664f71556c4e34586863565862425542667a6368614546796d554b4e4341494c49663664394632435055545775316d78436b684b354e78486d343849716c416c305177326a6a644d3633484b612b33757036356a4e7866776648566d793377707a37517767447267464b435a394a69787970364456317a4862753335592b48486230725a55554a4236456267467649696d524b62435156636b53624658776e4c353448764b2f67654a5478764776433131535752574f4a597746537342442f70367437394b64316130685441675a6d2f63754c6a41703976726144387a336f715978426a794e7344694a7979494574453256313261446658646e6b7944324f51757834444b615436354343496d3538346134776259424c306b49576d48426773646a6a46646578454e6f6341446863536e5146455544554d535a6c65674468366145334c52397537376845713131674a385865526c76624765464e644b34415653307a4f64487355636b4275696a665633315875466d655931696a677048353676514465647833376a32673035635878726d4d2f3335746a34594a63576e6c4d5561626a6e6264623432516b6c72674a7546347834793445576b2b507251704a7644507750314e3352352f6d38694a45767868352b766641676e37384a4845556a306e56614572416371445a6465783363686476545742304a33653746635878574345347648462b65323079484e34447158796f7a7a7050684a346f5174534c6351797270482f48707275305257723657784b416a7a4a44464a5039784c6859425848513876697351375a5a736351447041393439324f506b47534b544859666846433872567679323962706466714d58303051644143727969784f47776441766e344d2f4a3730424f5072726d4f7637652b57306144474536464649656e4e524f574b48436b76516669654d66453337794a30653547697257396b486e7773475942333676306236643178706537354a34464e726d4e2f566f35643155464e5654637670617234554b676374796b596f37784e57744957623670645536526f312b67764e2b67596948667172584d642b2b314b546f41655177365952624e714f34575538774d4e5645713671304c6e566c6a684c4e5543665833536d3262674e4f683046675250352b375674777a354d766d4c344252484c487a38703758464846384c584468647833596f77564349595670616b445544427431434c674a504e6837574b52463342365876434f6270584e566f744342722b6b6a4b43393857554644766644357335504d6c61476d474b79325044644d616f53314e6f77565a34352b786f5751482f7565684b69426e4c3230384949694e47333572676d73724d4a7633315a616d30594b73386155315775394b654979434e6b664939586130345a47416f72545a782f323443737a6d5137536c616251676139536170436c6a4965726e64475437504f6346474a31336664782f5549465a6647514f7477357467526f74794a7176614773657530585335776d3531524c2b454742302f4737702f6866447443724e486e4c6435503261746b434e466d544e312b67614d76547176717a4c6b7441576a395a74446a4171793869395a6e635963482b6c354b7468576d4f416f334e345761717454364d4657664d316e6a6a39344330434675656e78684c686858346463465136414c2f6256706f4e3035705949566e376341363344634257625830614c6369614c41497237694f66485756433347665072503034794369346a7230566545584236307547616531573571336a5363436b48463557756f3674443933586145485737496f48487743664b476b33454170356c7859704b696f3357673842506a4a4d61304b5a697646782b4a397a664c4f324f6b306c6f72644f6c364c57452f493459422b6c786a486376576a36345558706272754f76635577725475416933793866674e34777a4374753444667549363975722f7a304441744135674a2f4d624836777258735a2f575675664c4b4d4f306a696a54526c6e4364657a75776668526768426b556349775169574f6279426e4d556934526a47674c32575262396c774866746977375361674a454b336938414c6a424d367775676866524557514c594247787a485476516d3059797577567267477258736263617069574142754163306b6372716e51776d7254574b7646393143376c4c545570344342677652626b763745617542502f53776644434c6b7967486738427279462f7a68724a346850436e705469485841484643367666714451684d5761556c454257706e486b764a477765754846654b3556706a5361394c336b50522f2b3741655a6d2f6e5155306c7a4157564d486c434473583137714f2f62725757733241456d5137577639475a4737695970554134733331685a2b326c574b7555694243454a395a5639443732714b3161794e7a452b65584b6f4d463867353148524933336e3562546446504c334d642b3150447450594833737949632f444a4c6a304c5863652b515264707a59416373676845614255703562744b2b6235494c44455455446f4152384b71654650646b6c4c6c6765765932344278686d6e64416c786134585a387465765973335678316c5136657056466b5469394a5446457748546c50426168732f6f6a6e71356a58775a4d4142367177477865445a79677856677a344676496d734c77776f775648736372656e384e7a2b753373552f5873566341307733546d6748384570684765744a7665426c6d37566253457a3558756f3739754c6130584a307574704f2b756157535344474962344852676c77305257614f63734752636d4738715746626630665a6457774a58474759316c576b4a2f7847414e38476a6949393172775836664868634f6266304534396742322f35554d79782f394635743874774672535a314d73427a61376a7232357a4c36325837714e666f685442334277685a616554566c2b55376d5a50567a70737145467551684d62556c4d456a425a73526e5456525757443552542f463348396f44504d6e38666b4f2f5737384748417879546f32585833552f66634f4d4179755076346e2f33593856766c396658767865425345766944304b6f6e69387362374b6a44566671584e4e6f4e4c7146484c5159787849544258784c3058756e534d7072646135704e4272517179794b306558344b656d4e4641714e59323561504f767762703172476f314743334c412f4f54684e634f42437857396230594b5054617230576930494265445a444a354d34724451424a65746d6657726461357074466f6476442f434478784e65526848454941414141415355564f524b35435949493d, 'bxcv', 'Ahorros', '5423452');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presentacion`
--

CREATE TABLE `presentacion` (
  `IdPresentacion` int(12) NOT NULL,
  `Nombre` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `presentacion`
--

INSERT INTO `presentacion` (`IdPresentacion`, `Nombre`) VALUES
(1, 'wert'),
(2, 'cajaaaa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `IdProducto` int(12) NOT NULL,
  `IdMarca` int(12) DEFAULT NULL,
  `IdPresentacion` int(12) DEFAULT NULL,
  `IdTipoProducto` int(12) DEFAULT NULL,
  `CodigoProducto` int(12) NOT NULL,
  `IdUnidadMedida` int(12) DEFAULT NULL,
  `NombreProducto` varchar(256) NOT NULL,
  `PrecioSugerido` double NOT NULL,
  `StockMaximo` int(4) NOT NULL,
  `StockMinimo` int(4) NOT NULL,
  `Existencias` int(4) NOT NULL,
  `Contenido` varchar(512) NOT NULL,
  `Estado_P` tinyint(2) NOT NULL,
  `ImagenProducto` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`IdProducto`, `IdMarca`, `IdPresentacion`, `IdTipoProducto`, `CodigoProducto`, `IdUnidadMedida`, `NombreProducto`, `PrecioSugerido`, `StockMaximo`, `StockMinimo`, `Existencias`, `Contenido`, `Estado_P`, `ImagenProducto`) VALUES
(4, 1, 1, 1, 4, 1, 'Cerveza Heiniken', 6500, 6, 2, 1251, '375 ml', 4, 'Productos/img/1599849442_80c0af_5aa936de83034f308e642e2778a91c3b_mv2.jpg'),
(5, 1, 1, 1, 20245, 1, 'cerveza', 3200, 10, 5, 26, '255', 1, 'Productos/img/1605285406_WhatsApp Image 2020-11-05 at 2.14.01 PM.jpeg'),
(14, 1, 1, 2, 444, 1, 'zsdjh', 2000, 10, 5, 5, '500', 4, 'Productos/img/1601309048_aguardiente-antioqueno.jpg'),
(15, 3, 1, 1, 2545, 3, 'ron', 200, 10, 5, 5, '500', 4, ''),
(16, 2, 1, 1, 254, 1, 'aguardiente', 3000, 10, 5, 5, '500', 4, 'Productos/img/1601309460_aguardiente-antioqueno.jpg'),
(43, 1, 1, 1, 25450, 1, 'nmhfg', 1000, 5, 4, 502, '500', 1, ''),
(45, 1, 1, 1, 21245, 1, 'fghj25', 2000, 5, 2, 500, '500', 1, 'Productos/img/1605217706_calendario2020.png'),
(46, 1, 1, 1, 58, 1, 'fdgh', 2000, 4, 5, 52, '500', 1, ''),
(47, 1, 1, 1, 555, 1, 'sopa', 656565, 66, 66, 65, '6565', 1, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `IdProveedor` int(11) NOT NULL,
  `Nombre` varchar(256) NOT NULL,
  `Telefono` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`IdProveedor`, `Nombre`, `Telefono`) VALUES
(1, 'Pipe', 2343234),
(2, 'jaime', 31124),
(3, 'pedro', 314845278);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_documento`
--

CREATE TABLE `tipo_documento` (
  `IdTipoDocumento` int(11) NOT NULL,
  `Nombre_Documento` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_documento`
--

INSERT INTO `tipo_documento` (`IdTipoDocumento`, `Nombre_Documento`) VALUES
(1, 'Cedulaaaa'),
(2, 'Cedula Extranjera'),
(3, 'NIT');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_novedad`
--

CREATE TABLE `tipo_novedad` (
  `IdTipoNovedad` int(11) NOT NULL,
  `Nombre_Novedad` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_novedad`
--

INSERT INTO `tipo_novedad` (`IdTipoNovedad`, `Nombre_Novedad`) VALUES
(1, 'Perdida'),
(2, 'Renovacion');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_producto`
--

CREATE TABLE `tipo_producto` (
  `IdTipoProducto` int(12) NOT NULL,
  `Nombre` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_producto`
--

INSERT INTO `tipo_producto` (`IdTipoProducto`, `Nombre`) VALUES
(1, 'Licorres'),
(2, 'mecato'),
(3, 'fgbgh'),
(4, 'cigarrillos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidad_medida`
--

CREATE TABLE `unidad_medida` (
  `IdUnidadMedida` int(12) NOT NULL,
  `NombreUnidad` varchar(512) NOT NULL,
  `Conversion` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `unidad_medida`
--

INSERT INTO `unidad_medida` (`IdUnidadMedida`, `NombreUnidad`, `Conversion`) VALUES
(1, 'qwert', 345),
(2, 'unidad', 0),
(3, 'mililitrossss', 200),
(4, 'unidaddd', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL COMMENT 'auto incrementing user_id of each user, unique index',
  `user_type` int(11) NOT NULL,
  `firstname` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `user_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s name, unique',
  `user_password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s password in salted and hashed format',
  `user_email` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s email, unique',
  `estado_usuario` tinyint(4) NOT NULL,
  `date_added` datetime NOT NULL,
  `IdTipoDocumento` int(11) NOT NULL,
  `Numero_Documento` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `fecha_expiracion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='user data';

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`user_id`, `user_type`, `firstname`, `lastname`, `user_name`, `user_password_hash`, `user_email`, `estado_usuario`, `date_added`, `IdTipoDocumento`, `Numero_Documento`, `token`, `fecha_expiracion`) VALUES
(1, 2, 'Melisa', 'Montoya', 'Melisa', '$2y$10$Mc.6.kfod61xaY/gjs5y9O9P6lAgbooTxOolDmrs1vBf/c40ToCcK', 'melisamontoya.200014@gmail.com', 1, '2016-05-21 15:06:00', 0, '', 'jnXwULtx', '2020-11-05 04:40:31'),
(15, 1, 'Brahian', 'agurd', 'zaico', '$2y$10$65m.3/QirkDMfcT0p7NkLeumGcYChnayUBm/uaoLwA2JO473UKQxq', 'brayitan@gmail.com', 2, '2020-09-24 19:37:17', 0, '', '0', '0000-00-00 00:00:00'),
(16, 1, 'Brahian', 'dlfdl', 'dfldl', '$2y$10$k/nIIS52RsFkD/oCqew/POIt8H1cQVzj3R5mAPxkqsQhnwLyBTb6S', 'ldfldl@gslls.com', 0, '2020-09-24 19:38:32', 0, '', '0', '0000-00-00 00:00:00'),
(17, 2, 'brayitan', 'kfdkdk', 'perez', '$2y$10$D9.sMqGtOMeFXfHE.GF4puc.ccnW1P2TslbJ.Un0pv5kua7Mj95Ym', 'dlfldl@flfglfl.com', 2, '2020-09-24 19:50:31', 0, '', '0', '0000-00-00 00:00:00'),
(20, 1, 'ana', 'montoya', 'pedro', '$2y$10$inV.OynNTzzBpyKEMWF35eJlvPatVlwfcSCHcsrghg1mjRCLNU.r2', 'melisa25@gmail.com', 2, '2020-10-27 12:16:16', 2, '10154515', '0', '0000-00-00 00:00:00'),
(22, 2, 'pedro', 'gonzales', 'gonzales', '$2y$10$PgGKZDEymmUMnQMF1AEIMeb1Z494G6V2Cu2orejlTRF7cZK74IeL.', 'gna@gmail.com', 1, '2020-10-27 21:39:36', 1, '1021465', '0', '0000-00-00 00:00:00'),
(23, 2, 'niun', 'peroe', 'oe', '$2y$10$7i8IwBbji9AO12DAsuHmEOhIwXPx9jkmLGHtPwYkTyCDtKqy0cTFG', 'peru@gmail.com', 1, '2020-10-27 21:41:25', 1, '123456789', '0', '0000-00-00 00:00:00'),
(24, 1, 'maria', 'gonzales', 'meloo', '$2y$10$PHZUrg3qPX5BKHAPFm8F6eMKAv6UZlAgwhrbf2mG0y9oWTNfiqFL.', 'melisalo@gmail.com', 1, '2020-11-03 21:01:00', 1, '20254512', '', '0000-00-00 00:00:00'),
(25, 1, 'pedro', 'jaime', 'jaime', '$2y$10$TD1snzbr6QjzKQl.jh5txu5srBi7LaBs8H8i.MrupzxbZZE.gIQUm', 'jaime@gmail.com', 1, '2020-11-03 21:01:42', 1, '45451245', '', '0000-00-00 00:00:00'),
(26, 1, 'Jonathan', 'Ortizz', 'Jonathanor30', '$2y$10$g5pG5PCCBpQtD6CZyvKeJ.Hvc0QeYsLHGd/PfqFpdXmdsjVndfYha', 'jonathanor9808@gmail.com', 1, '2020-11-09 18:47:17', 1, '1020487157', 'ylbFGJ5e', '2020-11-12 23:38:32');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `IdVenta` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `IdCliente` int(11) NOT NULL,
  `IdEstadoVenta` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `observaciones` varchar(255) NOT NULL,
  `hora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`IdVenta`, `user_id`, `IdCliente`, `IdEstadoVenta`, `fecha`, `observaciones`, `hora`) VALUES
(1, 1, 1, 1, '2020-11-10', 'lk', '13:01:31'),
(2, 1, 2, 1, '2020-11-10', 'do', '13:06:02');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`IdCliente`),
  ADD KEY `IdTipoDocumento` (`IdTipoDocumento`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`IdCompra`),
  ADD KEY `IdProveedor` (`IdProveedor`);

--
-- Indices de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD PRIMARY KEY (`IdDetalleCompra`),
  ADD KEY `IdProducto` (`IdProducto`),
  ADD KEY `IdCompra` (`IdCompra`);

--
-- Indices de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD PRIMARY KEY (`IdDetalleVenta`),
  ADD KEY `IdUnidadMedida` (`IdUnidadMedida`),
  ADD KEY `IdVenta` (`IdVenta`),
  ADD KEY `IdProducto` (`IdProducto`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`IdEstado`);

--
-- Indices de la tabla `estado_venta`
--
ALTER TABLE `estado_venta`
  ADD PRIMARY KEY (`IdEstadoVenta`);

--
-- Indices de la tabla `home`
--
ALTER TABLE `home`
  ADD PRIMARY KEY (`IdHome`);

--
-- Indices de la tabla `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`IdMarca`);

--
-- Indices de la tabla `modulos_asignados`
--
ALTER TABLE `modulos_asignados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `novedad`
--
ALTER TABLE `novedad`
  ADD PRIMARY KEY (`IdNovedad`),
  ADD KEY `IdProducto` (`IdProducto`),
  ADD KEY `IdTipoNovedad` (`IdTipoNovedad`);

--
-- Indices de la tabla `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`id_perfil`);

--
-- Indices de la tabla `presentacion`
--
ALTER TABLE `presentacion`
  ADD PRIMARY KEY (`IdPresentacion`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`IdProducto`),
  ADD KEY `IdMarca` (`IdMarca`),
  ADD KEY `IdPresentacion` (`IdPresentacion`),
  ADD KEY `IdTipoProducto` (`IdTipoProducto`),
  ADD KEY `IdUnidadMedida` (`IdUnidadMedida`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`IdProveedor`);

--
-- Indices de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  ADD PRIMARY KEY (`IdTipoDocumento`);

--
-- Indices de la tabla `tipo_novedad`
--
ALTER TABLE `tipo_novedad`
  ADD PRIMARY KEY (`IdTipoNovedad`);

--
-- Indices de la tabla `tipo_producto`
--
ALTER TABLE `tipo_producto`
  ADD PRIMARY KEY (`IdTipoProducto`);

--
-- Indices de la tabla `unidad_medida`
--
ALTER TABLE `unidad_medida`
  ADD PRIMARY KEY (`IdUnidadMedida`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`IdVenta`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `IdCliente` (`IdCliente`),
  ADD KEY `IdEstadoVenta` (`IdEstadoVenta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `IdCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `IdCompra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  MODIFY `IdDetalleCompra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  MODIFY `IdDetalleVenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `IdEstado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estado_venta`
--
ALTER TABLE `estado_venta`
  MODIFY `IdEstadoVenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `home`
--
ALTER TABLE `home`
  MODIFY `IdHome` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `marca`
--
ALTER TABLE `marca`
  MODIFY `IdMarca` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `modulos_asignados`
--
ALTER TABLE `modulos_asignados`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `novedad`
--
ALTER TABLE `novedad`
  MODIFY `IdNovedad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `perfil`
--
ALTER TABLE `perfil`
  MODIFY `id_perfil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `presentacion`
--
ALTER TABLE `presentacion`
  MODIFY `IdPresentacion` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `IdProducto` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `IdProveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  MODIFY `IdTipoDocumento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipo_novedad`
--
ALTER TABLE `tipo_novedad`
  MODIFY `IdTipoNovedad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipo_producto`
--
ALTER TABLE `tipo_producto`
  MODIFY `IdTipoProducto` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `unidad_medida`
--
ALTER TABLE `unidad_medida`
  MODIFY `IdUnidadMedida` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing user_id of each user, unique index', AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `IdVenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `IdTipoDocumento` FOREIGN KEY (`IdTipoDocumento`) REFERENCES `tipo_documento` (`IdTipoDocumento`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `IdProveedor` FOREIGN KEY (`IdProveedor`) REFERENCES `proveedor` (`IdProveedor`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD CONSTRAINT `IdCompra` FOREIGN KEY (`IdCompra`) REFERENCES `compra` (`IdCompra`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `IdProducto` FOREIGN KEY (`IdProducto`) REFERENCES `producto` (`IdProducto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `novedad`
--
ALTER TABLE `novedad`
  ADD CONSTRAINT `IdTipoNovedad` FOREIGN KEY (`IdTipoNovedad`) REFERENCES `tipo_novedad` (`IdTipoNovedad`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `IdMarca` FOREIGN KEY (`IdMarca`) REFERENCES `marca` (`IdMarca`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `IdPresentacion` FOREIGN KEY (`IdPresentacion`) REFERENCES `presentacion` (`IdPresentacion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `IdTipoProducto` FOREIGN KEY (`IdTipoProducto`) REFERENCES `tipo_producto` (`IdTipoProducto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`IdUnidadMedida`) REFERENCES `unidad_medida` (`IdUnidadMedida`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `IdCliente` FOREIGN KEY (`IdCliente`) REFERENCES `cliente` (`IdCliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `IdEstadoVenta` FOREIGN KEY (`IdEstadoVenta`) REFERENCES `estado_venta` (`IdEstadoVenta`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

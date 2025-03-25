import{d as p,E as R,e as s,o as t,a as l,b as n,r as U,w as o,g as r,n as b,t as C,A as M,B as j,i as I,C as Q,k as D,j as W,c as _,f as m,u as K,F as z,h as G,W as B}from"./app-B7i476IW.js";import{b as O,a as J}from"./DialogModal-DKPmDXSA.js";import{_ as L}from"./InputError-BAp61ugy.js";import{_ as P}from"./PrimaryButton-Pht67KKk.js";import{_ as A}from"./SecondaryButton-BVjf0Ddl.js";import{_ as N}from"./TextInput-eH0qOyXf.js";import{_ as X}from"./DangerButton-E82NNXuZ.js";import{_ as Y}from"./InputLabel-DrC7EUNk.js";import{_ as Z}from"./_plugin-vue_export-helper-DlAUqK2U.js";import"./SectionTitle-COl5Vu3l.js";const ee={class:"mt-4"},y={__name:"ConfirmsPassword",props:{title:{type:String,default:"Confirm Password"},content:{type:String,default:"For your security, please confirm your password to continue."},button:{type:String,default:"Confirm"}},emits:["confirmed"],setup(w,{emit:S}){const x=S,u=p(!1),e=R({password:"",error:"",processing:!1}),c=p(null),g=()=>{axios.get(route("password.confirmation")).then(i=>{i.data.confirmed?x("confirmed"):(u.value=!0,setTimeout(()=>c.value.focus(),250))})},v=()=>{e.processing=!0,axios.post(route("password.confirm"),{password:e.password}).then(()=>{e.processing=!1,f(),j().then(()=>x("confirmed"))}).catch(i=>{e.processing=!1,e.error=i.response.data.errors.password[0],c.value.focus()})},f=()=>{u.value=!1,e.password="",e.error=""};return(i,d)=>(t(),s("span",null,[l("span",{onClick:g},[U(i.$slots,"default")]),n(O,{show:u.value,onClose:f},{title:o(()=>[r(C(w.title),1)]),content:o(()=>[r(C(w.content)+" ",1),l("div",ee,[n(N,{ref_key:"passwordInput",ref:c,modelValue:e.password,"onUpdate:modelValue":d[0]||(d[0]=T=>e.password=T),type:"password",class:"mt-1 block w-3/4",placeholder:"Password",autocomplete:"current-password",onKeyup:M(v,["enter"])},null,8,["modelValue"]),n(L,{message:e.error,class:"mt-2"},null,8,["message"])])]),footer:o(()=>[n(A,{onClick:f},{default:o(()=>d[1]||(d[1]=[r(" Cancel ")])),_:1}),n(P,{class:b(["ms-3",{"opacity-25":e.processing}]),disabled:e.processing,onClick:v},{default:o(()=>[r(C(w.button),1)]),_:1},8,["class","disabled"])]),_:1},8,["show"])]))}},ae={key:0,class:"text-lg font-medium text-gray-900"},te={key:1,class:"text-lg font-medium text-gray-900"},oe={key:2,class:"text-lg font-medium text-gray-900"},se={key:3},ne={key:0},re={class:"mt-4 max-w-xl text-sm text-gray-600"},ie={key:0,class:"font-semibold"},le={key:1},ue=["innerHTML"],de={key:0,class:"mt-4 max-w-xl text-sm text-gray-600"},ce={class:"font-semibold"},me=["innerHTML"],fe={key:1,class:"mt-4"},ke={key:1},pe={class:"grid gap-1 max-w-xl mt-4 px-4 py-4 font-mono text-sm bg-gray-100 rounded-lg"},ve={class:"mt-5"},ge={key:0},_e={key:1},ye={__name:"TwoFactorAuthenticationForm",props:{requiresConfirmation:Boolean},setup(w){const S=w,x=I(),u=p(!1),e=p(!1),c=p(!1),g=p(null),v=p(null),f=p([]),i=Q({code:""}),d=D(()=>{var k;return!u.value&&((k=x.props.auth.user)==null?void 0:k.two_factor_enabled)});W(d,()=>{d.value||(i.reset(),i.clearErrors())});const T=()=>{u.value=!0,B.post(route("two-factor.enable"),{},{preserveScroll:!0,onSuccess:()=>Promise.all([q(),E(),F()]),onFinish:()=>{u.value=!1,e.value=S.requiresConfirmation}})},q=()=>axios.get(route("two-factor.qr-code")).then(k=>{g.value=k.data.svg}),E=()=>axios.get(route("two-factor.secret-key")).then(k=>{v.value=k.data.secretKey}),F=()=>axios.get(route("two-factor.recovery-codes")).then(k=>{f.value=k.data}),$=()=>{i.post(route("two-factor.confirm"),{errorBag:"confirmTwoFactorAuthentication",preserveScroll:!0,preserveState:!0,onSuccess:()=>{e.value=!1,g.value=null,v.value=null}})},H=()=>{axios.post(route("two-factor.recovery-codes")).then(()=>F())},V=()=>{c.value=!0,B.delete(route("two-factor.disable"),{preserveScroll:!0,onSuccess:()=>{c.value=!1,e.value=!1}})};return(k,a)=>(t(),_(J,null,{title:o(()=>a[1]||(a[1]=[r(" Autentikasi Dua Faktor ")])),description:o(()=>a[2]||(a[2]=[r(" Tambahkan keamanan ekstra ke akun Anda menggunakan autentikasi dua faktor. ")])),content:o(()=>[d.value&&!e.value?(t(),s("h3",ae," Anda telah mengaktifkan autentikasi dua faktor. ")):d.value&&e.value?(t(),s("h3",te," Selesaikan pengaktifan autentikasi dua faktor. ")):(t(),s("h3",oe," Anda belum mengaktifkan autentikasi dua faktor. ")),a[11]||(a[11]=l("div",{class:"mt-3 max-w-xl text-sm text-gray-600"},[l("p",null," Saat autentikasi dua faktor diaktifkan, Anda akan diminta untuk memasukkan token acak yang aman selama proses autentikasi. Anda dapat mengambil token ini dari aplikasi Google Authenticator di ponsel Anda. ")],-1)),d.value?(t(),s("div",se,[g.value?(t(),s("div",ne,[l("div",re,[e.value?(t(),s("p",ie," Untuk menyelesaikan pengaktifan autentikasi dua faktor, pindai kode QR berikut menggunakan aplikasi autentikator di ponsel Anda atau masukkan kunci setup dan berikan kode OTP yang dihasilkan. ")):(t(),s("p",le," Autentikasi dua faktor sekarang diaktifkan. Pindai kode QR berikut menggunakan aplikasi autentikator di ponsel Anda atau masukkan kunci setup. "))]),l("div",{class:"mt-4 p-2 inline-block bg-white",innerHTML:g.value},null,8,ue),v.value?(t(),s("div",de,[l("p",ce,[a[3]||(a[3]=r(" Kunci Setup: ")),l("span",{innerHTML:v.value},null,8,me)])])):m("",!0),e.value?(t(),s("div",fe,[n(Y,{for:"code",value:"Kode"}),n(N,{id:"code",modelValue:K(i).code,"onUpdate:modelValue":a[0]||(a[0]=h=>K(i).code=h),type:"text",name:"code",class:"block mt-1 w-full md:w-1/2",inputmode:"numeric",autofocus:"",autocomplete:"one-time-code",onKeyup:M($,["enter"])},null,8,["modelValue"]),n(L,{message:K(i).errors.code,class:"mt-2"},null,8,["message"])])):m("",!0)])):m("",!0),f.value.length>0&&!e.value?(t(),s("div",ke,[a[4]||(a[4]=l("div",{class:"mt-4 max-w-xl text-sm text-gray-600"},[l("p",{class:"font-semibold"}," Simpan kode pemulihan ini di manajer kata sandi yang aman. Mereka dapat digunakan untuk memulihkan akses ke akun Anda jika perangkat autentikasi dua faktor Anda hilang. ")],-1)),l("div",pe,[(t(!0),s(z,null,G(f.value,h=>(t(),s("div",{key:h},C(h),1))),128))])])):m("",!0)])):m("",!0),l("div",ve,[d.value?(t(),s("div",_e,[n(y,{onConfirmed:$},{default:o(()=>[e.value?(t(),_(P,{key:0,type:"button",class:b(["me-3",{"opacity-25":u.value}]),disabled:u.value},{default:o(()=>a[6]||(a[6]=[r(" Konfirmasi ")])),_:1},8,["class","disabled"])):m("",!0)]),_:1}),n(y,{onConfirmed:H},{default:o(()=>[f.value.length>0&&!e.value?(t(),_(A,{key:0,class:"me-3"},{default:o(()=>a[7]||(a[7]=[r(" Buat Ulang Kode Pemulihan ")])),_:1})):m("",!0)]),_:1}),n(y,{onConfirmed:F},{default:o(()=>[f.value.length===0&&!e.value?(t(),_(A,{key:0,class:"me-3"},{default:o(()=>a[8]||(a[8]=[r(" Tampilkan Kode Pemulihan ")])),_:1})):m("",!0)]),_:1}),n(y,{onConfirmed:V},{default:o(()=>[e.value?(t(),_(A,{key:0,class:b({"opacity-25":c.value}),disabled:c.value},{default:o(()=>a[9]||(a[9]=[r(" Batal ")])),_:1},8,["class","disabled"])):m("",!0)]),_:1}),n(y,{onConfirmed:V},{default:o(()=>[e.value?m("",!0):(t(),_(X,{key:0,class:b([{"opacity-25":c.value},"bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 ease-in-out transform hover:scale-105"]),disabled:c.value},{default:o(()=>a[10]||(a[10]=[r(" Nonaktifkan ")])),_:1},8,["class","disabled"]))]),_:1})])):(t(),s("div",ge,[n(y,{onConfirmed:T},{default:o(()=>[n(P,{type:"button",class:b([{"opacity-25":u.value},"bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 ease-in-out transform hover:scale-105"]),disabled:u.value},{default:o(()=>a[5]||(a[5]=[r(" Aktifkan ")])),_:1},8,["class","disabled"])]),_:1})]))])]),_:1}))}},Pe=Z(ye,[["__scopeId","data-v-c8dc434f"]]);export{Pe as default};

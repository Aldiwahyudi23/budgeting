import{C as m,d,e as u,o as p,b as t,u as o,x as f,w as r,a as e,q as c,n as _,g as w,F as x}from"./app-DMOSpIva.js";import{A as g}from"./AuthenticationCard-D1Zic7Ex.js";import{_ as k}from"./InputError-Duae4cza.js";import{_ as b}from"./InputLabel-C9C-EeLH.js";import{_ as v}from"./PrimaryButton-D3g5zZMV.js";import{_ as A}from"./TextInput-BhKf-tHw.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const y={class:"flex justify-end mt-4"},j={__name:"ConfirmPassword",setup(V){const a=m({password:""}),l=d(null),n=()=>{a.post(route("password.confirm"),{onFinish:()=>{a.reset(),l.value.focus()}})};return(C,s)=>(p(),u(x,null,[t(o(f),{title:"Area Aman"}),t(g,null,{logo:r(()=>s[1]||(s[1]=[e("div",{class:"text-center"},[e("div",{class:"text-4xl font-bold text-indigo-600"},"Keluarga Ma HAYA"),e("div",{class:"text-lg text-gray-600 mt-2"},"ATURR Yukk")],-1)])),default:r(()=>[s[3]||(s[3]=e("div",{class:"mb-4 text-sm text-gray-600 text-center"}," Ini adalah area aman dari aplikasi. Silakan konfirmasi kata sandi Anda sebelum melanjutkan. ",-1)),e("form",{onSubmit:c(n,["prevent"])},[e("div",null,[t(b,{for:"password",value:"Kata Sandi"}),t(A,{id:"password",ref_key:"passwordInput",ref:l,modelValue:o(a).password,"onUpdate:modelValue":s[0]||(s[0]=i=>o(a).password=i),type:"password",class:"mt-1 block w-full",required:"",autocomplete:"current-password",autofocus:""},null,8,["modelValue"]),t(k,{class:"mt-2",message:o(a).errors.password},null,8,["message"])]),e("div",y,[t(v,{class:_(["ms-4",{"opacity-25":o(a).processing}]),disabled:o(a).processing},{default:r(()=>s[2]||(s[2]=[w(" Konfirmasi ")])),_:1},8,["class","disabled"])])],32)]),_:1})],64))}};export{j as default};

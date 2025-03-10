import{d,C as b,e as s,o as r,b as o,u as t,q as C,w as m,a as i,F as n,g as l,m as _,n as w,x as V}from"./app-BAsRu4FG.js";import{A as h}from"./AuthenticationCard-BoinKGLR.js";import{_ as $}from"./AuthenticationCardLogo-D7vB0UFt.js";import{_ as p}from"./InputError-CnX_wM75.js";import{_ as v}from"./InputLabel-C3zg-Mom.js";import{_ as I}from"./PrimaryButton--d7rAwVm.js";import{_ as g}from"./TextInput-BRg-EK8C.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const T={class:"mb-4 text-sm text-gray-600"},U={key:0},B={key:1},F={class:"flex items-center justify-end mt-4"},S={__name:"TwoFactorChallenge",setup(N){const c=d(!1),e=b({code:"",recovery_code:""}),f=d(null),y=d(null),k=async()=>{c.value^=!0,await V(),c.value?(f.value.focus(),e.code=""):(y.value.focus(),e.recovery_code="")},x=()=>{e.post(route("two-factor.login"))};return(A,a)=>(r(),s(n,null,[o(t(C),{title:"Two-factor Confirmation"}),o(h,null,{logo:m(()=>[o($)]),default:m(()=>[i("div",T,[c.value?(r(),s(n,{key:1},[l(" Please confirm access to your account by entering one of your emergency recovery codes. ")],64)):(r(),s(n,{key:0},[l(" Please confirm access to your account by entering the authentication code provided by your authenticator application. ")],64))]),i("form",{onSubmit:_(x,["prevent"])},[c.value?(r(),s("div",B,[o(v,{for:"recovery_code",value:"Recovery Code"}),o(g,{id:"recovery_code",ref_key:"recoveryCodeInput",ref:f,modelValue:t(e).recovery_code,"onUpdate:modelValue":a[1]||(a[1]=u=>t(e).recovery_code=u),type:"text",class:"mt-1 block w-full",autocomplete:"one-time-code"},null,8,["modelValue"]),o(p,{class:"mt-2",message:t(e).errors.recovery_code},null,8,["message"])])):(r(),s("div",U,[o(v,{for:"code",value:"Code"}),o(g,{id:"code",ref_key:"codeInput",ref:y,modelValue:t(e).code,"onUpdate:modelValue":a[0]||(a[0]=u=>t(e).code=u),type:"text",inputmode:"numeric",class:"mt-1 block w-full",autofocus:"",autocomplete:"one-time-code"},null,8,["modelValue"]),o(p,{class:"mt-2",message:t(e).errors.code},null,8,["message"])])),i("div",F,[i("button",{type:"button",class:"text-sm text-gray-600 hover:text-gray-900 underline cursor-pointer",onClick:_(k,["prevent"])},[c.value?(r(),s(n,{key:1},[l(" Use an authentication code ")],64)):(r(),s(n,{key:0},[l(" Use a recovery code ")],64))]),o(I,{class:w(["ms-4",{"opacity-25":t(e).processing}]),disabled:t(e).processing},{default:m(()=>a[2]||(a[2]=[l(" Log in ")])),_:1},8,["class","disabled"])])],32)]),_:1})],64))}};export{S as default};

import{T as u,d as E,f as n,i as _,e as s,u as r,w as I,o as M,B as f,l as L}from"./vue-i18n-locales.generated-DazkPcQT.js";import{_ as R}from"./BaseButton-BhZf0EJx.js";import{_ as t}from"./FormInput-DeHhKyjW.js";import{L as S}from"./Loading-C3NjX0uh.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const c={class:"grid gap-4"},x={__name:"LaravelMailersend",props:{mailersend:Object,mailer:Object},setup(A){var m,i,d;const o=A,e=u({MAIL_MAILER:"mailersend",MAILERSEND_API_KEY:(m=o.mailersend)==null?void 0:m.apiKey,MAIL_FROM_ADDRESS:(i=o.mailer)==null?void 0:i.address,MAIL_FROM_NAME:(d=o.mailer)==null?void 0:d.name}),p=()=>{e.put(window.route("admin.settings.mail",{mailer:"mailersend"}),{preserveScroll:!0,preserveState:!0})};return(N,a)=>(M(),E("div",c,[a[4]||(a[4]=n("p",{class:"font-semibold text-sm text-primary"},[_(" Get your credentials "),n("a",{class:"text-sky-400 hover:text-sky-500 ml-1",href:"https://www.mailersend.com/"}," Here ")],-1)),s(t,{label:"Universal Email from Address",class:"max-w-lg",error:r(e).errors.MAIL_FROM_ADDRESS,modelValue:r(e).MAIL_FROM_ADDRESS,"onUpdate:modelValue":a[0]||(a[0]=l=>r(e).MAIL_FROM_ADDRESS=l)},null,8,["error","modelValue"]),s(t,{label:"Universal Email from Name",error:r(e).errors.MAIL_FROM_NAME,modelValue:r(e).MAIL_FROM_NAME,"onUpdate:modelValue":a[1]||(a[1]=l=>r(e).MAIL_FROM_NAME=l)},null,8,["error","modelValue"]),s(t,{label:"MailerSend API Key",error:r(e).errors.MAILERSEND_API_KEY,modelValue:r(e).MAILERSEND_API_KEY,"onUpdate:modelValue":a[2]||(a[2]=l=>r(e).MAILERSEND_API_KEY=l)},null,8,["error","modelValue"]),s(R,{disabled:r(e).processing,onClick:p,class:"w-full mt-4",primary:""},{default:I(()=>[r(e).processing?(M(),f(S,{key:0,class:"mr-2 -ml-1"})):L("",!0),a[3]||(a[3]=_(" Save Mailersend Settings "))]),_:1},8,["disabled"])]))}};export{x as default};

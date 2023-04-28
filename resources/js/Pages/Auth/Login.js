import React, { useEffect } from 'react';
import { useForm, usePage } from '@inertiajs/inertia-react';
import ValidationErrors from '@/Components/ValidationErrors';

export default function Login({ captcha }) {

    const { perusahaan, flash } = usePage().props;

    const { data, setData, post, processing, errors, reset } = useForm({
        email: '',
        password: '',
        remember: '',
        captcha: '',
    });

    useEffect(() => {
        flash.type && toast[flash.type](flash.messages);
        return () => {
            reset('password');
        };
    }, []);

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.type === 'checkbox' ? event.target.checked : event.target.value);
    };

    const submit = (e) => {
        e.preventDefault();

        post(route('login'), {
            onSuccess: () => {
                location.reload()
            }
        });
    };

    return (
        <>
            <div className="d-flex flex-column flex-root h-screen">
                <div className="d-flex flex-column flex-lg-row flex-column-fluid">
                    <div
                        className="d-flex flex-column flex-lg-row-auto w-xl-600px positon-xl-relative"
                        style={{ backgroundColor: "#ffe3b1" }}
                    >
                        <div className="d-flex flex-column position-xl-fixed top-0 bottom-0 w-xl-600px scroll-y">
                            <div className="d-flex flex-row-fluid flex-column text-center p-10 pt-lg-20">
                                <h1>
                                    <i className='m-0 p-0'>Selamat Datang</i>
                                </h1>
                                <div className='mx-auto'>
                                    <img alt="Logo" src={perusahaan ? '/storage/' + perusahaan.logo : '/assets/media/logos/logo-2.svg'} className="h-40px h-lg-60px" />
                                </div>
                                <h1>
                                    {perusahaan.nama}
                                </h1>
                                <h6>{perusahaan.alamat}</h6>

                            </div>
                            <div
                                className="d-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-100px min-h-lg-350px"
                                style={{
                                    backgroundImage: "url(/assets/media/illustrations/dozzy-1/6.png)"
                                }}
                            />
                        </div>
                    </div>


                    <div className="d-flex flex-column flex-lg-row-fluid py-10 bg-white">
                        <div className="d-flex flex-center flex-column flex-column-fluid">
                            <div className="w-lg-500px p-10 p-lg-15 mx-auto">
                                <form
                                    className="form w-100"
                                    noValidate="novalidate"
                                    id="kt_sign_in_form"
                                    onSubmit={submit}
                                >
                                    <div className="text-center mb-10">
                                        <h1 className="text-dark mb-3 text-xl font-semibold">Halaman Login</h1>
                                    </div>
                                
                                    <ValidationErrors errors={errors} />

                                    <div className="fv-row mb-10">
                                        <label className="form-label fs-6 fw-bolder text-dark">
                                            Email
                                        </label>
                                        <input
                                            className="form-control form-control-lg form-control-solid"
                                            type="text"
                                            name="email"
                                            value={data.email}
                                            onChange={onHandleChange}
                                            autoComplete="off"
                                        />
                                    </div>
                                    <div className="fv-row mb-10">
                                        <div className="d-flex flex-stack mb-2">
                                            <label className="form-label fw-bolder text-dark fs-6 mb-0">
                                                Password
                                            </label>
                                            {/* <a
                                                href="#"
                                                className="link-primary fs-6 fw-bolder"
                                            >
                                                Forgot Password ?
                                            </a> */}
                                        </div>
                                        <input
                                            className="form-control form-control-lg form-control-solid"
                                            type="password"
                                            name="password"
                                            value={data.password}
                                            onChange={onHandleChange}
                                            autoComplete="off"
                                        />
                                    </div>
                                    <div className='flex mb-4'>
                                        <div dangerouslySetInnerHTML={{ __html: captcha }} />
                                        <input
                                            className="form-control form-control-lg form-control-solid ml-4"
                                            type="number"
                                            name="captcha"
                                            value={data.captcha}
                                            onChange={onHandleChange}
                                            autoComplete="off"
                                        />
                                    </div>
                                    <div className="text-center">
                                        <button
                                            type="submit"
                                            id="kt_sign_in_submit"
                                            className="btn btn-lg btn-primary w-100 mb-5"
                                        >
                                            <span className="indicator-label">Continue</span>
                                            <span className="indicator-progress">
                                                Please wait...
                                                <span className="spinner-border spinner-border-sm align-middle ms-2" />
                                            </span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div className="d-flex flex-center flex-wrap fs-6 p-5 pb-0">
                            <div className="d-flex flex-center fw-bold fs-6">
                                <a href="http://wa.me/6282396151291" className="text-muted text-hover-primary px-2" target="_blank" >
                                    About
                                </a>
                                <a href="http://wa.me/6282396151291" className="text-muted text-hover-primary px-2" target="_blank" >
                                    Support
                                </a>
                                <a href="http://wa.me/6282396151291" className="text-muted text-hover-primary px-2" target="_blank" >
                                    Contact
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </>
    );
}


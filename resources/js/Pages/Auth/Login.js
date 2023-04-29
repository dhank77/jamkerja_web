import React, { useEffect } from "react";
import { Link, useForm, usePage } from "@inertiajs/inertia-react";
import ValidationErrors from "@/Components/ValidationErrors";

export default function Login({ captcha }) {
    const { perusahaan, flash } = usePage().props;

    const { data, setData, post, processing, errors, reset } = useForm({
        email: "",
        password: "",
        remember: "",
        captcha: "",
    });

    useEffect(() => {
        flash.type && toast[flash.type](flash.messages);
        return () => {
            reset("password");
        };
    }, []);

    const onHandleChange = (event) => {
        setData(
            event.target.name,
            event.target.type === "checkbox"
                ? event.target.checked
                : event.target.value
        );
    };

    const submit = (e) => {
        e.preventDefault();

        post(route("login"), {
            onSuccess: () => {
                location.reload();
            },
        });
    };

    return (
        <>
            <div className="d-flex flex-column flex-root h-screen">
                <div className="d-flex flex-column flex-lg-row flex-column-fluid">
                    <div
                        className="d-flex flex-column flex-lg-row-fluid py-10"
                        style={{ backgroundColor: "#B0C4DE", "minHeight": "100vh", }}
                    >
                        <div className="d-flex flex-center flex-column flex-column-fluid">
                            <div>
                                <img
                                    alt="Logo"
                                    src="/logo.png"
                                    className="h-60px h-lg-80px"
                                />
                            </div>
                            <h1 className="text-dark">JamKerja.ID</h1>
                            <br/>
                            <br/>
                            <div className="w-lg-500px p-10 p-lg-15 card">
                                <form
                                    className="form w-100"
                                    noValidate="novalidate"
                                    id="kt_sign_in_form"
                                    onSubmit={submit}
                                >
                                    <div className="text-center mb-10">
                                        <h1 className="text-dark mb-3 text-xl font-semibold">
                                            Halaman Login
                                        </h1>
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
                                            <Link
                                                href={route('password.request')}
                                                className="link-primary fs-6 fw-bolder"
                                            >
                                                Lupa Password ?
                                            </Link>
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
                                    <div className="flex mb-4">
                                        <div
                                            dangerouslySetInnerHTML={{
                                                __html: captcha,
                                            }}
                                        />
                                        <input
                                            className="form-control form-control-lg form-control-solid ml-4"
                                            type="number"
                                            name="captcha"
                                            value={data.captcha}
                                            onChange={onHandleChange}
                                            autoComplete="off"
                                        />
                                    </div>
                                    <br/>
                                    <div className="text-center">
                                        <button
                                            type="submit"
                                            id="kt_sign_in_submit"
                                            className="btn btn-lg btn-primary w-100 mb-5"
                                        >
                                            <span className="indicator-label">
                                                Login
                                            </span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div className="d-flex flex-center flex-wrap fs-6 p-5 pb-0">
                            <div className="d-flex flex-center fw-bold fs-6">
                                <a
                                    href="http://wa.me/6282396151291"
                                    className="text-white fw-bolder text-hover-primary px-2"
                                    target="_blank"
                                >
                                    About
                                </a>
                                <a
                                    href="http://wa.me/6282396151291"
                                    className="text-white fw-bolder text-hover-primary px-2"
                                    target="_blank"
                                >
                                    Support
                                </a>
                                <a
                                    href="http://wa.me/6282396151291"
                                    className="text-white fw-bolder text-hover-primary px-2"
                                    target="_blank"
                                >
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

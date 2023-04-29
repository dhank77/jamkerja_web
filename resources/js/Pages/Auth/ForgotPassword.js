import React from "react";
import Button from "@/Components/Button";
import Guest from "@/Layouts/Guest";
import Input from "@/Components/Input";
import ValidationErrors from "@/Components/ValidationErrors";
import { Head, Link, useForm } from "@inertiajs/inertia-react";

export default function ForgotPassword({ status }) {
    const { data, setData, post, processing, errors } = useForm({
        email: "",
    });

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value);
    };

    const submit = (e) => {
        e.preventDefault();

        post(route("password.email"));
    };

    return (
        <Guest>
            <Head title="Forgot Password" />

            {status && (
                <div className="mb-4 font-medium text-sm text-green-600">
                    {status}
                </div>
            )}

            <form onSubmit={submit}>
                <br />
                <h6 className="text-center">Halaman Reset Password</h6>
                <br />
                <br />
                <div className="fv-row mb-4">
                    <label className="form-label fs-6 fw-bolder text-dark">
                        Email
                    </label>
                    <Input
                        type="text"
                        name="email"
                        value={data.email}
                        className="form-control form-control-lg form-control-solid"
                        isFocused={true}
                        handleChange={onHandleChange}
                    />
                    <ValidationErrors errors={errors} />
                </div>

                <div>
                    <button
                        type="submit"
                        className="btn btn-lg btn-primary w-100 mb-5"
                    >
                        Reset Password
                    </button>
                    <br />
                    <hr />
                    <br />
                    <Link
                        href={route("login")}
                        className="btn btn-lg btn-danger w-100 mb-5"
                    >
                        Kembali Kehalaman Login
                    </Link>
                </div>
            </form>
        </Guest>
    );
}

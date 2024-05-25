import { mount } from "@vue/test-utils";
import { describe, it, expect } from "vitest";

import LoginPage from "../LoginPage.vue";

describe("LoginPage", () => {
  it("should render login page", () => {
    const wrapper = mount(LoginPage);
    expect(wrapper.html()).toMatchSnapshot();
  });
});

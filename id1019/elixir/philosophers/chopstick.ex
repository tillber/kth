# chopstick.ex
defmodule Chopstick do
  def start do
    stick = spawn_link(fn -> :available end)
  end

  def available() do
    receive do
      {:request, from} ->
        send(from, :available)
        gone()
      :quit -> :ok
    end
  end

  def gone() do
    receive do
      :return -> available()
      :quit -> :ok
    end
  end

  def request(stick, timeout) do
    send(stick, {:request, self()})
    receive do
      :available -> :ok
    after timeout ->
      :nope
    end
  end

  def terminate(stick) do
    send(stick, :quit)
  end

  def get(stick) do
    send(stick, :return)
  end

  def sleep(0) do :ok end
  def sleep(t) do
    :timer.sleep(:rand.uniform(t))
  end
end

# philo.ex
defmodule Philosopher do
  def start(hunger, right, left, name, ctrl) do
    philosopher = spawn_link(fn -> dream(hunger, right, left, name, ctrl) end
  end

  def dream(0, _, _, name, ctrl) do
    IO.puts("#{name} is done.")
    send(ctrl, :done)
  end

  def dream(hunger, right, left, name, ctrl) do
    sleep(1000)
    IO.puts("#{name} is dreaming.")
    wait(hunger, right, left, name, ctrl)
  end

  def wait(hunger, right, left, name, ctrl) do
    sleep(1000)
    IO.puts("#{name} is waiting.")
    case Chopstick.request(right, 5000) do
      :ok ->
        sleep(1000)
        case Chopstick.request(left, 5000) do
          :ok ->
            eat(hunger, right, left, name, ctrl)
          :nope ->
            wait(hunger, right, left, name, ctrl)
        end
      :nope ->
        wait(hunger, right, left, name, ctrl)
    end
  end

  def eat(hunger, right, left, name, ctrl) do
    sleep(1000)
    IO.puts("#{name} is eating.")
    Chopstick.get(right)
    Chopstick.get(left)
    dream(hunger - 1, right, left, name, ctrl)
  end
end
